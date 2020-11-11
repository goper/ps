<?php

abstract class AbstractPayment
{
    protected $paymentClient;
    protected $invoiceEntity;
    protected $userEntity;

    public function __construct(
        IPaymentClient $paymentClient,
        InvoiceEntity $invoiceEntity,
        UserEntity $userEntity
    )
    {
        $this->invoiceEntity = $invoiceEntity;
        $this->userEntity = $userEntity;
        $this->paymentClient = $paymentClient;
    }

    /**
     * Создание транзакции
     *
     * @return InnerTransactionEntity
     * @throws Exception
     */
    public function create(): InnerTransactionEntity
    {
        $innerTransaction = $this->getActiveTransactionByInvoice();
        $hash = $innerTransaction ? $innerTransaction->getHash() : null;

        // если у транзакции уже есть хеш
        if ($hash) {
            // получаем данные о транзакции
            $outerTransaction = $this->paymentClient->retrieveOuterTransaction($hash);

            // если транзакция ожидает ответ от гетвея, не нужно создавать новую, а сразу возратить
            if ($outerTransaction->isAwaitingGatewayResponse()) {
                $innerTransaction->awaitingGatewayResponse();
                return $innerTransaction;
            }

            // если внешняя транзакция истекла или отменена, отменяем внутреннюю и потом создаем новую
            if ($outerTransaction->isExpired() || $outerTransaction->isCanceled()) {
                $innerTransaction->cancel();
                $hash = $this->generateHash();
            }

            // возможно транзакция еще может быть в статусе заершена?
            
            // оставшийся вариант состояния транзакции  - STARTED_STATUS
        }

        // e.g. for strike it can be via $this->createOuterTransaction($data)
        $hash = $hash ?? $this->generateHash();
        
        // создание новой транзакции в бд
        $innerTransaction = $this->startInnerTransaction($hash);
        return $innerTransaction;
    }

    /**
     * Обработка и отправка платежа (пока только для солютрон)
     *
     * @param  int  $transactionId  из url
     * @param  array  $paymentData  данные для осущ. платежа
     * @return InnerTransactionEntity
     * @throws Exception
     */
    public function pay(int $transactionId, array $paymentData): InnerTransactionEntity
    {
        $innerTransaction = $this->getActiveTransactionById($transactionId);

        if ($innerTransaction === null) {
            throw new Exception('Такой транзакции не существует');
        }

        $outerTransaction = $this->paymentClient->createOuterTransaction($paymentData);

        // данные заполнены неправильно (3d)
        if ($outerTransaction->isValid() === false) {
            $this->redirectToPaymentForm();
        }

        // есть ли инфа о транзакции?
        if ($outerTransaction->getHash()) {
            if ($outerTransaction->getHash() !== $innerTransaction->getHash()) {
                $this->updateHash($outerTransaction->getHash());
            }

            if ($outerTransaction->isExpired() || $outerTransaction->isCanceled()) {
                $innerTransaction->cancel();
                //либо редирект на страницу cancel
                throw new Exception('Transaction is not correct');
            }

            if ($outerTransaction->isAwaitingGatewayResponse()) {
                $innerTransaction->awaitingGatewayResponse();
                throw new Exception('Current transaction is already in progress');
            }

            // предполагается редирект на стр success
            return $innerTransaction;
        }

        throw new Exception('Unknown error');
    }

    public function confirmation(string $answer, IParser $parser)
    {
        $outerTransaction = $parser->parseConfirmation($answer);
        $hash = $outerTransaction->getHash();
        $innerTransactionEntity = $this->getTransactionByHash($hash);

        if($outerTransaction->isPayed()) {
            $innerTransactionEntity->pay();
        }

    }

    /**
     * Форма с кнопкой `оплатить`
     */
    abstract public function redirectToPaymentForm(): void;

    /**
     *  Создание транзакции через клиент ( createOuterTransaction . Для солютрона будет null, данные берутся из invoice)
     *  Вычленение хеша из ответа
     *
     * @return string|null
     */
    abstract public function generateHash(): ?string;

    abstract public function updateHash(string $newHash): void;

    /**
     * Поиск активных транзакций в бд (в ожидании ответа или started)
     * @return InnerTransactionEntity
     */
    abstract public function getActiveTransactionByInvoice(): InnerTransactionEntity;

    abstract public function getActiveTransactionById(int $id): InnerTransactionEntity;

    abstract public function getTransactionByHash(string $hash): InnerTransactionEntity;

    /**
     * Создание транзакции в бд
     *
     * @param  string|null  $hash
     * @return InnerTransactionEntity
     */
    abstract public function startInnerTransaction(?string $hash): InnerTransactionEntity;
}