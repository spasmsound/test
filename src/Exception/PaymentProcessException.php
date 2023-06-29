<?php

namespace App\Exception;

class PaymentProcessException extends \Exception
{
    private ?string $paymentProcessorName;

    public function __construct(
        ?string $paymentProcessorName = null,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->paymentProcessorName = $paymentProcessorName;
    }

    public function getPaymentProcessorName(): ?string
    {
        return $this->paymentProcessorName;
    }
}
