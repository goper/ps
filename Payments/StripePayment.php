<?php

class StripePayment extends AbstractPayment
{
    public function __construct(
        IPaymentClient $client,
        InvoiceEntity $invoiceEntity,
        UserEntity $userEntity
        // дополнительные данные типа
        //EntityManagerInterface $em
    )
    {
        parent::__construct($client, $invoiceEntity, $userEntity);
    }


    public function redirectToPaymentForm(): void
    {
    }

    public function generateHash(): ?string
    {
    }

    public function updateHash(string $newHash): void
    {
    }

    public function getTransactionByHash(string $hash): InnerTransactionEntity
    {

    }

    public function getActiveTransactionByInvoice(): InnerTransactionEntity
    {
    }

    public function getActiveTransactionById(int $id): InnerTransactionEntity
    {
    }

    public function startInnerTransaction(?string $hash): InnerTransactionEntity
    {
    }
}