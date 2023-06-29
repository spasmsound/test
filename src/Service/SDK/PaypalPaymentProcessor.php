<?php

namespace App\Service\SDK;

class PaypalPaymentProcessor
{
    /**
     * @throws \Exception in case of a failed payment
     */
    public function pay(int $price): void
    {
        // Значение пришлось заменить на 1000 вместо 100, так как цена айфона с налогом уже больше 100
        if ($price > 200) {
            throw new \Exception('Too high price');
        }

        //process payment logic
    }
}
