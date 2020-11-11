<?php

Class StripePaymentClient implements IPaymentClient
{
    protected $parser;

    public function __construct(StripeParser $parser)
    {
        $this->parser = $parser;
    }

    public function createOuterTransaction(array $paymentData): StripeOuterTransactionEntity
    {
        // todo code to create transaction
        $answer = 'some_json_data';
        return $this->parser->parseCreatedOuterTransaction($answer);

    }

    public function retrieveOuterTransaction(string $hash): StripeOuterTransactionEntity
    {
        // todo code to retrieve transaction
        $answer = 'some_json_data';
        return $this->parser->parseRetrievedOuterTransaction($answer);
    }
}