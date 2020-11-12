<?php

interface IPayment
{
    public function create(): InnerTransactionEntity;
    public function pay(int $transactionId, array $paymentData): InnerTransactionEntity;
    public function confirmation(string $answer, IParser $parser): InnerTransactionEntity;
    public function refund(): InnerTransactionEntity;
}