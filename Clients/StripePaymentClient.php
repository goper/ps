<?php

Class StripePaymentClient implements IPaymentClient
{
    protected $parser;

    function __construct(StripeParser $parser)
    {
        $this->parser = $parser;
    }

    public function createOuterTransaction(array $paymentData): IOuterTransaction
    {
        // some logic
        $answer = 'json-answer';
        return $this->parser->parse($answer);
    }

    public function retrieveOuterTransaction(string $hash): IOuterTransaction
    {

    }
}