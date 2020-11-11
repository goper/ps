<?php

declare(strict_types=1);

interface IFormatter
{
    public function encode(array $arr): string;
    public function decode(array $str): string;
}