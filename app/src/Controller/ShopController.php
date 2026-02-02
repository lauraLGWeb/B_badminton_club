<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;
use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class ShopController extends AbstractController
{
    #[Route('/membre/Boutique', name: 'app_shop')]
    #[IsGranted('ROLE_MEMBRE')]
    public function shop(ProductRepository $ProductRepository, EntityManagerInterface $em): Response
    {
           $user = $this->getUser();
    
    // On récupère le panier SANS le créer
    $cart = $em->getRepository(Cart::class)->findOneBy([
        'user' => $user,
        'isPaid' => false
    ]);
    // Si pas de panier, $cart = null, c'est OK !

       $product = $ProductRepository->findAll();

        return $this->render('shop/index.html.twig', [
            'products' => $product,
            'cart'=>$cart,
        ]);
    }

}
