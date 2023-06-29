<?php

namespace App\Service\PaymentProcessor;

use App\Entity\Product;
use App\Exception\PaymentProcessException;
use App\Service\SDK\PaypalPaymentProcessor;

readonly class PayPalProcessor implements PaymentProcessor
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor
    )
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(int $amount, Product $product): void
    {
        try {
            $this->paypalPaymentProcessor->pay($amount / 100);
        } catch (\Exception $e) {
            throw new PaymentProcessException($this->getName(), $e->getMessage());
        }
    }

    public function getName(): string
    {
        return 'paypal';
    }

    public function isSupport(string $name): bool
    {
        return $name === $this->getName();
    }
}
