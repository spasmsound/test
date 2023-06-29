<?php

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Exception\PaymentProcessException;
use App\Model\RequestData;
use Doctrine\ORM\EntityManagerInterface;

readonly class PriceService
{
    public function __construct(
        private CountryService $countryService,
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @throws PaymentProcessException
     */
    public function calculatePrice(RequestData $requestData, Product $product): int
    {
        $coupon = null;
        if (!is_null($requestData->getCouponCode())) {
            /** @var ?Coupon $coupon */
            $coupon = $this
                ->entityManager
                ->getRepository(Coupon::class)
                ->findOneBy(['code' => $requestData->getCouponCode()]);

            if (is_null($coupon)) {
                throw new PaymentProcessException(
                    message: 'Coupon with code "' . $requestData->getCouponCode() . ' not found'
                );
            }
        }

        $productPrice = $product->getPrice();
        $taxPercentage = $this->countryService->getTaxPercentage($requestData->getTaxNumber());

        $checkoutPrice = $productPrice + ($productPrice * $taxPercentage / 100);

        if ($coupon instanceof Coupon) {
            if (Coupon::TYPE_PERCENT === $coupon->getType()) {
                return $checkoutPrice - ($checkoutPrice * $coupon->getValue() / 100);
            } else {
                return $checkoutPrice - $coupon->getValue();
            }
        }

        return $checkoutPrice;
    }
}
