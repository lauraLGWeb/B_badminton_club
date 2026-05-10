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
    #[IsGranted('ROLE_ADMIN')]
    public function shop( ProductRepository $ProductRepository, EntityManagerInterface $em): Response
    {
    
   
        
        $user = $this->getUser();
    
    // get the cart, no creation
    $cart = $em->getRepository(Cart::class)->findOneBy([
        'user' => $user,
        'isPaid' => false
    ]);


    // if no cart, it's ok!
       $product = $ProductRepository->findAll();

        return $this->render('shop/index.html.twig', [
            'products' => $product,
            'cart'=>$cart,
        ]);
    }

}
