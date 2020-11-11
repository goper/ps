<?php

class PaymentFactory
{
    protected $type;

    public function getPayment(int $paymentId, InvoiceEntity $invoiceEntity, UserEntity $userEntity)
    {
        if($paymentId === 1){
            $parser = new StripeParser();
            $client = new StripePaymentClient($parser);
            $this->type = new StripePayment($client, $invoiceEntity, $userEntity);
        }

        return $this->type;
    }
}
