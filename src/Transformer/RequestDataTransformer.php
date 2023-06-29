<?php

namespace App\Transformer;

use App\Model\RequestData;

class RequestDataTransformer
{
    public function transform(array $arrayData): RequestData
    {
        return new RequestData(
            product: $arrayData['product'],
            taxNumber: $arrayData['taxNumber'],
            paymentProcessor: $arrayData['paymentProcessor'],
            amount: $arrayData['amount'] ?? null,
            couponCode: $arrayData['couponCode'] ?? null
        );
    }

    public function reverseTransform(RequestData $requestData): array
    {
        return $requestData->toArray();
    }
}
