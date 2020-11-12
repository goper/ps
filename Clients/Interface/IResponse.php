<?php

declare(strict_types=1);

interface IResponse
{
    public function isError(): bool;
    public function errors(): ?array;
    public function response(): array;
    public function getTransaction(): IOuterTransaction;
    public function setResponse(array $arr): void;
}