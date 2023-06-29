<?php

namespace App\Service\PaymentProcessor;

use App\Exception\PaymentProcessException;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.payment_processor')]
interface PaymentProcessor
{
    public function isSupport(string $name): bool;

    /**
     * @throws PaymentProcessException
     */
    public function pay(int $amount): void;

    public function getName(): string;
}
