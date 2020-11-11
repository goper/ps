<?php

declare(strict_types=1);

interface IHydrator
{
    public function hydrate(object $obj): array;
    public function revert(array $arr): object;
}