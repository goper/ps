<?php

declare(strict_types=1);

interface IPaymentProcessor
{
    public function hydrator(): IHydrator;
    public function formatter(): IFormatter;
    public function operation(): IOperation;
    public function registerOperation(string $operationName):void;
}