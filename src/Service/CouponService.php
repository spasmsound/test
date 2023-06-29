<?php

namespace App\Service;

class CouponService
{
    public function generateCouponCode(): string
    {
        $prefix = chr(rand(65, 90)) . chr(rand(65, 90));
        $randomNumber = rand(10, 99);

        return $prefix . $randomNumber;
    }
}
