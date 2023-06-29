<?php

namespace App\Service\PaymentProcessor;

use App\Constants\PaymentProcessors;
use App\Exception\PaymentProcessException;
use App\Service\SDK\StripePaymentProcessor;
use App\Transformer\PriceTransformer;

readonly class StripeProcessor implements PaymentProcessor
{
    public function __construct(
        private StripePaymentProcessor $stripePaymentProcessor,
        private PriceTransformer $priceTransformer
    )
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(int $amount): void
    {
        $result = $this->stripePaymentProcessor->processPayment($this->priceTransformer->reverseTransform($amount));

        if (!$result) {
            throw new PaymentProcessException($this->getName(), 'Too low price');
        }
    }

    public function getName(): string
    {
        return PaymentProcessors::STRIPE;
    }

    public function isSupport(string $name): bool
    {
        return $name === $this->getName();
    }
}
