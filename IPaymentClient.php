<?php

interface IPaymentClient
{
    public function createOuterTransaction(array $paymentData): IOuterTransaction;
    public function retrieveOuterTransaction(string $hash): IOuterTransaction;
}