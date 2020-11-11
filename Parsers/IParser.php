<?php

interface IParser
{
    public function parse(string $body): IOuterTransaction;
}