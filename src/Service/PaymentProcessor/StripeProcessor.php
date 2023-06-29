<?php

namespace App\Service\PaymentProcessor;

use App\Entity\Product;
use App\Exception\PaymentProcessException;
use App\Service\SDK\StripePaymentProcessor;

readonly class StripeProcessor implements PaymentProcessor
{
    public function __construct(
        private StripePaymentProcessor $stripePaymentProcessor
    )
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(int $amount, Product $product): void
    {
        $result = $this->stripePaymentProcessor->processPayment($amount / 100);

        if (!$result) {
            throw new PaymentProcessException($this->getName());
        }
    }

    public function getName(): string
    {
        return 'stripe';
    }

    public function isSupport(string $name): bool
    {
        return $name === $this->getName();
    }
}
