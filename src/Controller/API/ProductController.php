<?php

namespace App\Controller\API;

use App\Entity\Product;
use App\Exception\PaymentProcessException;
use App\Form\BuyProductType;
use App\Form\CalculatePriceType;
use App\Service\PriceService;
use App\Service\ProductService;
use App\Transformer\PriceTransformer;
use App\Transformer\RequestDataTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/product')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly RequestDataTransformer $requestDataTransformer
    )
    {
    }

    #[Route(path: '/calculate-price', name: 'app_product_calculate_price', methods: 'POST')]
    public function calculatePrice(
        Request $request,
        PriceService $priceService,
        PriceTransformer $priceTransformer,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $requestArrayData = json_decode($request->getContent(), true);

        $form = $this->createForm(CalculatePriceType::class);
        $form->submit($requestArrayData);

        if (!$form->isValid()) {
            return new JsonResponse($this->getFormErrors($form), Response::HTTP_BAD_REQUEST);
        }

        $requestData = $this->requestDataTransformer->transform($requestArrayData);

        /** @var ?Product $product */
        $product = $entityManager->getRepository(Product::class)->find($requestData->getProduct());

        if (is_null($product)) {
            return new JsonResponse(
                ['message' => 'Product with ID: ' . $requestData->getProduct() . ' not found'],
                Response::HTTP_NOT_FOUND);
        }

        try {
            return new JsonResponse(
                $priceTransformer->reverseTransform(
                    $priceService->calculatePrice($requestData, $product)
                )
            );
        } catch (PaymentProcessException $exception) {
            $responseData = [];

            if ('' !== $exception->getMessage()) {
                $responseData['message'] = $exception->getMessage();
            }

            if (!is_null($exception->getPaymentProcessorName())) {
                $responseData['paymentProcessor'] = $exception->getPaymentProcessorName();
            }

            return new JsonResponse($responseData, $exception->getCode());
        }
    }

    #[Route(path: '/buy', name: 'app_product_buy', methods: 'POST')]
    public function buy(Request $request, ProductService $productService): Response
    {
        $requestArrayData = json_decode($request->getContent(), true);

        $form = $this->createForm(BuyProductType::class);
        $form->submit($requestArrayData);

        if (!$form->isValid()) {
            return new JsonResponse($this->getFormErrors($form), Response::HTTP_BAD_REQUEST);
        }

        $requestData = $this->requestDataTransformer->transform($requestArrayData);

        try {
            $productService->buy($requestData);
        } catch (PaymentProcessException $exception) {
            $responseData = [];

            if ('' !== $exception->getMessage()) {
                $responseData['message'] = $exception->getMessage();
            }

            if (!is_null($exception->getPaymentProcessorName())) {
                $responseData['paymentProcessor'] = $exception->getPaymentProcessorName();
            }

            return new JsonResponse($responseData, $exception->getCode());
        }

        return new JsonResponse();
    }

    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getFormErrors($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
