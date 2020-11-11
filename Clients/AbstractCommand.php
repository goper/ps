<?php

declare(strict_types=1);

abstract class AbstractCommand
{
    protected $paymentProcessor;

    public function __construct(IPaymentProcessor $paymentProcessor)
    {
        $this->paymentProcessor = $paymentProcessor;
    }

    public abstract function execute(IOuterTransaction $transaction): IResponse;
}