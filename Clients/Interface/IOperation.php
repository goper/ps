<?php

declare(strict_types=1);

interface IOperation
{
    public function execute(IRequest $request): ?string;
    public function isOperation(): bool;
}