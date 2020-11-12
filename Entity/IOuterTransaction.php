<?php

interface IOuterTransaction
{
    //public function getStatus(): string;
    public function isExpired(): bool;
    public function isCanceled(): bool;
    public function isAwaitingGatewayResponse(): bool;
    public function getHash(): bool;
    public function isValid(): bool;
    public function isPayed(): bool;
}