<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;

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


}
