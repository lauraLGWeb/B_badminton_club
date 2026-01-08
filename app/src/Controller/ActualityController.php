<?php

namespace App\Controller;
use App\Document\Actualities;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ActualityController extends AbstractController
{
    #[Route('/Actualites', name: 'app_actuality')]
    public function actuality(DocumentManager $dm): Response
    {
        $actualities = $dm->getRepository(Actualities::class)->findAll();
       

        return $this->render('home/actuality.html.twig', [
            'actualities' => $actualities,
        ]);
    }
}
