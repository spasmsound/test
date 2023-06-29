<?php

namespace App\Constants;

class PaymentProcessors
{
    public const PAYPAL = 'paypal';
    public const STRIPE = 'stripe';

    public static function getPaymentChoices(): array
    {
        return [
            self::STRIPE,
            self::PAYPAL
        ];
    }
}
