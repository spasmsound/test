<?php

namespace App\Transformer;

class PriceTransformer
{
    public function transform(int|float $price): int
    {
        return $price * 100;
    }

    public function reverseTransform(int $price): int|float
    {
        return $price / 100;
    }
}
