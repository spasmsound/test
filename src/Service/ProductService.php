<?php

namespace App\Service;

use App\Entity\Product;
use App\Exception\PaymentProcessException;
use App\Model\RequestData;
use App\Transformer\PriceTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class ProductService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaymentService $paymentService,
        private PriceTransformer $priceTransformer,
        private PriceService $priceService,
    )
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function buy(RequestData $requestData): void
    {
        /** @var ?Product $product */
        $product = $this->entityManager->getRepository(Product::class)->find($requestData->getProduct());

        if (is_null($product)) {
            throw new PaymentProcessException(
                message: 'Product with ID: ' . $requestData->getProduct() . ' not found',
                code: Response::HTTP_NOT_FOUND
            );
        }

        $checkoutPrice = $this->priceService->calculatePrice($requestData, $product);

        if ($this->priceTransformer->transform($requestData->getAmount()) < $checkoutPrice) {
            throw new PaymentProcessException(
                message: 'Not enough amount. Price: ' . $this->priceTransformer->reverseTransform($checkoutPrice)
            );
        }

        $paymentProcessor = $this->paymentService->getPaymentProcessor($requestData->getPaymentProcessor());
        $paymentProcessor->pay($this->priceTransformer->transform(
            $this->priceTransformer->reverseTransform($checkoutPrice))
        );
    }
}
