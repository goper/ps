<?php

declare(strict_types=1);

class CreateTransaction extends AbstractCommand
{
    const OPERATION_NAME = 'CreateTransaction';

    public function execute(IOuterTransaction $transaction): IResponse
    {
        $this->paymentProcessor->registerOperation(self::OPERATION_NAME);
        $str = $this->paymentProcessor->hydrator()->hydrate($transaction);
        $str = $this->paymentProcessor->formatter()->encode($str);
        $this->paymentProcessor->operation($str);
    }
}