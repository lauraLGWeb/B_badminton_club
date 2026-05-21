<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class ShopController extends AbstractController
{
  
    #[Route('/Boutique', name: 'app_shop')]
    public function historique(): Response
    {
        return $this->render('shop/index.html.twig');
    }

}
