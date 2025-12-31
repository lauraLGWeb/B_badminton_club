<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShopController extends AbstractController
{
    #[Route('/Boutique', name: 'app_shop')]
    public function shop(ProductRepository $ProductRepository): Response
    {

        $product = $ProductRepository->findAll();


        return $this->render('shop/index.html.twig', [
            'products' => $product,
        ]);
    }

       #[Route('/Panier', name: 'app_cart')]
    public function cart(): Response
    {
        return $this->render('shop/cart.html.twig');
    }

}
