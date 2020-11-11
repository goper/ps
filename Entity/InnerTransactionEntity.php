<?php

class InnerTransactionEntity
{

    public const CANCELED_STATUS = 'canceled';
    public const AWAITING_GATEWAY_RESPONSE_STATUS = 'awaiting_gateway_response';
    public const STARTED_STATUS = 'started';
    public const PAYED_STATUS = 'payed';

    private $hash;
    private $status;

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function changeStatus(string $status)
    {
        return $this->status = $status;
    }

    public function pay()
    {
        $this->status = self::PAYED_STATUS;
    }

    public function cancel()
    {
        $this->status = self::CANCELED_STATUS;
    }

    public function awaitingGatewayResponse()
    {
        $this->status = self::AWAITING_GATEWAY_RESPONSE_STATUS;
    }
}