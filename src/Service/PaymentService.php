<?php

namespace App\Service;

use App\Exception\PaymentProcessException;
use App\Service\PaymentProcessor\PaymentProcessor;

readonly class PaymentService
{
    public function __construct(
        private iterable $paymentProcessors
    )
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function getPaymentProcessor(string $name): PaymentProcessor
    {
        /** @var PaymentProcessor $paymentProcessor */
        foreach ($this->paymentProcessors as $paymentProcessor) {
            if ($paymentProcessor->isSupport($name)) {
                return $paymentProcessor;
            }
        }

        throw new PaymentProcessException();
    }
}
