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


    #[Route('/Actualites/detail/{id}', name: 'app_actualityDetail')]
    public function actualitydetail(DocumentManager $dm, $id): Response
    {
        $actuality = $dm->getRepository(Actualities::class)->find($id);

        // if(!$actuality){
        //     throw $this->createNotFoundException("pas d'actualitée");
        // }
       

        return $this->render('home/actualityDetail.html.twig', [
            'actuality' => $actuality,
        ]);
    }
}
