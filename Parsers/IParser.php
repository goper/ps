<?php

interface IParser
{
    public function parseRetrievedOuterTransaction(string $body): IOuterTransaction;
    public function parseCreatedOuterTransaction(string $body): IOuterTransaction;
    public function parseConfirmation(string $body): IOuterTransaction;
}