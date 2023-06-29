<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class PaymentProcessException extends \Exception
{
    private ?string $paymentProcessorName;

    public function __construct(
        ?string $paymentProcessorName = null,
        string $message = '',
        int $code = Response::HTTP_BAD_REQUEST,
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
