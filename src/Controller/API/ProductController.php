<?php

namespace App\Controller\API;

use App\Entity\Product;
use App\Exception\PaymentProcessException;
use App\Service\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/product')]
class ProductController extends AbstractController
{
    #[Route(path: '/calculate-price', name: 'app_product_calculate_price', methods: 'POST')]
    public function calculatePrice(
        Request $request,
        PaymentService $paymentService,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $data = $request->get('requestData');

        /** @var ?Product $product */
        $product = $entityManager->getRepository(Product::class)->find($data['product']);

        if (is_null($product)) {
            return new JsonResponse(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        try {
            $paymentProcessor = $paymentService->getPaymentProcessor($data['paymentProcessor']);
        } catch (PaymentProcessException) {
            return new JsonResponse(
                ['message' => 'Payment processor not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        try {
            $paymentProcessor->pay($data['amount'] * 100, $product);
        } catch (PaymentProcessException $e) {
            return new JsonResponse([
                'payment_processor' => $e->getPaymentProcessorName(),
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse();
    }

    #[Route(path: '/buy', name: 'app_product_buy', methods: 'POST')]
    public function buy(Request $request): Response
    {
        $data = $request->get('requestData');

        return new Response('');
    }
}
