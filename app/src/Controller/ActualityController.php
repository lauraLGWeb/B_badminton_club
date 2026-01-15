<?php

namespace App\Controller;
use App\Document\Actualities;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ActualityType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Http\Attribute\IsGranted;


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
    #[IsGranted('ROLE_ADMIN')]
    public function actualitydetail(DocumentManager $dm, $id): Response
    {

        //getting the actuality details
        $actuality = $dm->getRepository(Actualities::class)->find($id);


        return $this->render('home/actualityDetail.html.twig', [
            'actuality' => $actuality,
        ]);
    }



    //create actuality
    #[Route('/Actualites/création', name: 'app_createActuality')]
    #[IsGranted('ROLE_ADMIN')]
    public function createActuality(Request $request, DocumentManager $dm,): Response
    {

        $newActuForm = new Actualities();
        $form = $this->createForm(ActualityType::class, $newActuForm);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
                          
            $dm->persist($newActuForm);
            $dm->flush();        

            $this->addFlash('success', 'Actualité créée avec succès !');
            return $this->redirectToRoute('app_actuality');
            }
        
         return $this->render('admin/createActuality.html.twig', [
          'form' => $form,
           ]);
}


 //modify actuality
    #[Route('/Actualites/modifier/{id}', name: 'app_modifyActuality')]
    #[IsGranted('ROLE_ADMIN')]
    public function modifyActuality(Request $request, DocumentManager $dm, $id): Response
    {

        
        $actu = $dm->getRepository(Actualities::class)->find($id);

        $formulaire = $this->createForm(ActualityType::class, $actu);

        //get the actual information 
        $title = $actu->getTitle();
        $description = $actu->getDescription();
        $picture = $actu->getPicture();
        $date = $actu->getEventOn();

        //fill the form with old info
        $formulaire->get('title')->setData($title);
        $formulaire->get('description')->setData($description);
        $formulaire->get('picture')->setData($picture);
        $formulaire->get('eventOn')->setData($date);
        

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted()&& $formulaire->isValid())
        {
         //set up the new role into the database
        $title = $formulaire->get('title')->getData();
        $actu->setTitle($title);

        $description = $formulaire->get('description')->getData();
        $actu->setDescription($description);

        $picture = $formulaire->get('picture')->getData();
        $actu->setPicture($picture);

        $date = $formulaire->get('eventOn')->getData();  
        $actu->setEventOn($date);  
     

        $dm-> flush();

             $this->addFlash('success', 'Actualité mise à jour avec succès !');          
            return $this->redirectToRoute('app_actuality');
           
           
        } 

         return $this->render("admin/createActuality.html.twig", ["form" => $formulaire]);
     }





    //delete the actuality
    #[Route('/Actualites/suppression/{id}', name: 'app_deleteActuality')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteActuality(DocumentManager $dm, $id): Response
    {

        //getting the actuality details
        $actualityToDelete = $dm->getRepository(Actualities::class)->find($id);
        
        $dm->remove($actualityToDelete);
        $dm->flush();

        $this->addFlash('success', 'Actualité supprimée avec succès !');

       return $this->redirectToRoute('app_actuality');
    }
}
