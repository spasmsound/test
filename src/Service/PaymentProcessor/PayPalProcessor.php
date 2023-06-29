<?php

namespace App\Service\PaymentProcessor;

use App\Constants\PaymentProcessors;
use App\Exception\PaymentProcessException;
use App\Service\SDK\PaypalPaymentProcessor;
use App\Transformer\PriceTransformer;

readonly class PayPalProcessor implements PaymentProcessor
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor,
        private PriceTransformer $priceTransformer
    )
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(int $amount): void
    {
        try {
            $this->paypalPaymentProcessor->pay($this->priceTransformer->reverseTransform($amount));
        } catch (\Exception $e) {
            throw new PaymentProcessException($this->getName(), $e->getMessage());
        }
    }

    public function getName(): string
    {
        return PaymentProcessors::PAYPAL;
    }

    public function isSupport(string $name): bool
    {
        return $name === $this->getName();
    }
}
