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

        //get all the actualities
        $actualities = $dm->getRepository(Actualities::class)->findAll();
       

        return $this->render('home/actuality.html.twig', [
            'actualities' => $actualities,
        ]);
    }


    #[Route('/Actualites/detail/{id}', name: 'app_actualityDetail')]
    public function actualitydetail(DocumentManager $dm, $id): Response
    {

        //getting the actuality details
        $actuality = $dm->getRepository(Actualities::class)->find($id);


        return $this->render('home/actualityDetail.html.twig', [
            'actuality' => $actuality,
        ]);
    }
}
