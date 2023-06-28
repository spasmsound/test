<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/product')]
class ProductController extends AbstractController
{
    #[Route(path: '/calculate-price', name: 'app_product_calculate_price', methods: 'POST')]
    public function calculatePrice(): Response
    {
        return new Response('');
    }

    #[Route(path: '/buy', name: 'app_product_buy', methods: 'POST')]
    public function buy(): Response
    {
        return new Response('');
    }
}
