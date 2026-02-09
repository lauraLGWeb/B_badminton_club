<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\InternshipsRepository;
use App\Entity\InternshipPlayer;
use App\Form\InternshipType;
use App\Repository\InternshipPlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class InternshipsController extends AbstractController
{



    //get the intersnhips 
    #[Route('/Leclub/Stages', name: 'app_internships')]
    public function internships(InternshipsRepository $ir): Response
    {
          $internships = $ir->findAll();

        return $this->render('internships/index.html.twig', [
            'internships' => $internships,
        ]);

    }

    #[Route('/Leclub/Stages/Inscription/{id}', name: 'app_intershipInscription')]
    public function intershipInscription($id, InternshipsRepository $ir,InternshipPlayerRepository $Ipr,  Request $request, EntityManagerInterface $em): Response
    {

        //get the internship clicked on
        $internship = $ir->find($id);

        //create the new player and associate to the internship
        $newPlayer = new InternshipPlayer();
        $newPlayer->setInternship($internship);


        //create the form
        $form = $this->createForm(InternshipType::class, $newPlayer);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            
        
            $em->persist($newPlayer);
            $em->flush();        

            $this->addFlash('success', 'tu es bien inscrit !');
            return $this->redirectToRoute('app_internships');
            }
        
         return $this->render('internships/eachInternship.html.twig', [
          'form' => $form,
          'internship' => $internship,
           ]); 
    }

}

