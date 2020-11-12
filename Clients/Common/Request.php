<?php

declare(strict_types=1);

class Request implements IRequest
{
    protected $transaction;
    protected $request;

    public function __construct(IOuterTransaction $transaction, string $request)
    {
        $this->transaction = $transaction;
        $this->request = $request;
    }

    public function getTransaction(): IOuterTransaction
    {
        return $this->transaction;
    }

    public function getRequest(): string
    {
        return $this->request;
    }
}