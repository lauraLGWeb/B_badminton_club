<?php

namespace App\Controller;
use App\Document\Actualities;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ActualityType;

use Symfony\Component\HttpFoundation\Request;

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



    //create actuality
    #[Route('/Actualites/création/', name: 'app_createActuality')]
    public function createActuality(Request $request, DocumentManager $dm,): Response
    {

        $newActuForm = new Actualities();
        $form = $this->createForm(ActualityType::class, $newActuForm);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
                          
            $dm->persist($newActuForm);
            $dm->flush();        

            $this->addFlash('success', 'Actualité créée avec succès !');
            return $this->render('home/adminDashboard.html.twig');
            }
        
         return $this->render('admin/createActuality.html.twig', [
          'form' => $form,
           ]);
}


    //delete the actuality
    #[Route('/Actualites/suppression/{id}', name: 'app_deleteActuality')]
    public function deleteActuality(DocumentManager $dm, $id): Response
    {

        //getting the actuality details
        $actualityToDelete = $dm->getRepository(Actualities::class)->find($id);
        
        $dm->remove($actualityToDelete);
        $dm->flush();

        return $this->render('home/actuality.html.twig', [
            
        ]);
    }
}
