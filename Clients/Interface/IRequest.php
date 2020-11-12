<?php

declare(strict_types=1);

interface IRequest
{
    public function getTransaction(): IOuterTransaction;
    public function getRequest(): string;
}