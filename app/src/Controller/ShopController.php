<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CartService;

use Symfony\Component\Security\Http\Attribute\IsGranted;


final class ShopController extends AbstractController
{
    #[Route('/membre/Boutique', name: 'app_shop')]
    #[IsGranted('ROLE_MEMBRE')]
    public function shop(ProductRepository $ProductRepository, CartService $cartService): Response
    {
        $user = $this->getUser();
        $cart = $cartService->getOrCreateActiveCart($user);


        $product = $ProductRepository->findAll();


        return $this->render('shop/index.html.twig', [
            'products' => $product,
            'cart' => $cart,
        ]);
    }



}
