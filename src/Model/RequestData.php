<?php

namespace App\Model;

readonly class RequestData
{
    public function __construct(
        private int     $product,
        private string  $taxNumber,
        private string  $paymentProcessor,
        private ?int    $amount = null,
        private ?string $couponCode = null
    )
    {
    }

    public function toArray(): array
    {
        $data = [
            'product' => $this->product,
            'taxNumber' => $this->taxNumber,
            'paymentProcessor' => $this->paymentProcessor
        ];

        if (!is_null($this->amount)) {
            $data['amount'] = $this->amount;
        }

        if (!is_null($this->couponCode)) {
            $data['couponCode'] = $this->couponCode;
        }

        return $data;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}
