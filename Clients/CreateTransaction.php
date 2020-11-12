<?php

declare(strict_types=1);

class CreateTransaction extends AbstractCommand
{
    const OPERATION_NAME = 'CreateTransaction';

    public function execute(IOuterTransaction $transaction): ?IResponse
    {
        $operation = $this->paymentProcessor->operation();
        $this->paymentProcessor->registerOperation(self::OPERATION_NAME);
        if ($operation->isOperation() === false) {
            return null;
        }
        $hydrator = $this->paymentProcessor->hydrator();
        $formatter = $this->paymentProcessor->formatter();

        $arr = $hydrator->hydrate($transaction);
        $str = $formatter->encode($arr);
        $request = new Request($transaction, $str);
        $response = $operation->execute($request);
        $response = $formatter->decode($response);
        return $hydrator->revert($response);
    }
}