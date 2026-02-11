<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\InternshipsRepository;
use App\Entity\InternshipPlayer;
use App\Form\InternshipType;
use App\Repository\InternshipPlayerRepository;
use App\Form\InternshipCreationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Internships;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class InternshipsController extends AbstractController
{



    //get all the intersnhips 
    #[Route('/Leclub/Stages', name: 'app_internships')]
    public function internships(InternshipsRepository $ir): Response
    {
          $internships = $ir->findAll();

        return $this->render('internships/index.html.twig', [
            'internships' => $internships,
        ]);

    }


    //get the one i click on to make inscription 
    #[Route('/Leclub/Stages/Inscription/{id}', name: 'app_intershipInscription')]
    public function intershipInscription(int $id, InternshipsRepository $ir,  Request $request, EntityManagerInterface $em): Response
    {

        //get the internship clicked on
        $internship = $ir->find($id);


        if (!$internship) {
            throw $this->createNotFoundException('Stage introuvable');
}

        //create the new player and associate to the internship
        $newPlayer = new InternshipPlayer();
        $newPlayer->setInternship($internship);


        //create the form
        $form = $this->createForm(InternshipType::class, $newPlayer);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            // incrementation of "alreadybooked"
            $internship->setAlreadyBooked($internship->getAlreadyBooked()+1);

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



// admin and trainer part : see the inscription on one internship
   #[Route('entraineur/Leclub/Stages/inscriptions/{id}', name: 'app_bookedPlayersInternship')]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('ROLE_ENTRAINEUR')]
    public function bookedPlayersInternship(int $id, InternshipsRepository $ir): Response
    {
           //get the internship clicked on
        $internship = $ir->find($id);

        $players = $internship->getInternshipPlayers();

        return $this->render('internships/bookedPlayersInternship.html.twig', [
            'internship' => $internship,
            'players'=>$players,
        ]);

    }


// cancel player from the selected internship
   #[Route('entraineur/Leclub/Stages/inscriptions/supprimer/{id}', name: 'app_deletePlayersInternship')]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('ROLE_ENTRAINEUR')]
    public function deletePlayersInternship(int $id, EntityManagerInterface $em,InternshipPlayerRepository $ipr, Request $request): Response
    {

        //get the player clicked on
        $player = $ipr->find($id);


        // token check 
        $token = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('delete_player_' . $player->getId(), $token)) {
            $this->addFlash('error', 'Token invalide');
            return $this->redirectToRoute('app_internships');
        }

         // check that player exist
        if (!$player) {
        throw $this->createNotFoundException('Joueur introuvable');
    }

        //get the internship clicked on
        $internship = $player->getInternship();

        // getting all the players to still mention them on the page after deleting the person
        $players = $internship->getInternshipPlayers();

         // decrementation of "alreadybooked"
        $internship->setAlreadyBooked($internship->getAlreadyBooked()-1);

        $em->remove($player);
         $em->flush();

        $this->addFlash('success', 'joueur bien enlevé de ce stage ');

          return $this->redirectToRoute('app_bookedPlayersInternship', [
        'id' => $internship->getId()
    ]);


    }



// create an internship (admon only)
   #[Route('admin/Leclub/Stages/creation', name: 'app_createInternship')]
    #[IsGranted('ROLE_ADMIN')]
    public function createInternship(Request $request, EntityManagerInterface $em): Response
    {
    $newInternship = new Internships();
        $form = $this->createForm(InternshipCreationType::class, $newInternship);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
                          
            $em->persist($newInternship);
            $em->flush();        

            $this->addFlash('success', 'Stage créée avec succès !');
            return $this->redirectToRoute('app_internships');
            }

        return $this->render('admin/CreateInternship.html.twig', [
            'form' => $form,
        ]);

    }



}

