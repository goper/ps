<?php

declare(strict_types=1);

interface IOperation
{
    public function execute(string $str): ?string;
    public function isOperation(): bool;
}