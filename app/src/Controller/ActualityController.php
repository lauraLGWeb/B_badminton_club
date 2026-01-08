<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ActualityController extends AbstractController
{
    #[Route('/actualités', name: 'app_actuality')]
    public function index(): Response
    {
        return $this->render('actuality/index.html.twig', [
            'controller_name' => 'ActualityController',
        ]);
    }
}
