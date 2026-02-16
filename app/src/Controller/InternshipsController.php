<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\InternshipsRepository;
use App\Entity\InternshipPlayer;
use App\Entity\User;
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
          $internships = $ir->findAllOrderedByDate();

        return $this->render('internships/index.html.twig', [
            'internships' => $internships,
        ]);

    }


    //get the one i clicked on to make inscription 
    #[Route('/Leclub/Stages/Inscription/{id}', name: 'app_intershipInscription')]
    public function intershipInscription(int $id, InternshipsRepository $ir,  Request $request, EntityManagerInterface $em): Response
    {    
        // get akl the interships
        $internships = $ir->findAllOrderedByDate();
        //get the internship clicked on
        $internship = $ir->find($id);
        //get the user connected 
        $user = $this->getUser();

        if (!$internship) {
            throw $this->createNotFoundException('Stage introuvable');
}
       
        //create the new player and associate to the internship
        $newPlayer = new InternshipPlayer();
        $newPlayer->setInternship($internship);


        //--------cannot book twice for the same interhnship----------
       $existingBooking = $em->getRepository(InternshipPlayer::class)->findOneBy([
       'user' => $user,
       'internship' => $internship
    ]);
      if ($existingBooking) {
            $this->addFlash('erreur', 'Attention tu as déja réservé ce stage   !');

            return $this->render('internships/index.html.twig', [
            'internships' => $internships,
        ]); 
        } 




        //create the form
        $form = $this->createForm(InternshipType::class, $newPlayer);
        $form->handleRequest($request);

        
         if ($form->isSubmitted() && $form->isValid()) {
            // incrementation of "alreadybooked"
            $internship->setAlreadyBooked($internship->getAlreadyBooked()+1);
            

            $newPlayer->setUser($this->getUser());

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
   #[Route('/entraineur/Leclub/Stages/inscriptions/{id}', name: 'app_bookedPlayersInternship')]
    #[IsGranted('ROLE_ENTRAINEUR')]
    public function bookedPlayersInternship(int $id, EntityManagerInterface $em,InternshipsRepository $ir): Response
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
   #[Route('/entraineur/Leclub/Stages/inscriptions/supprimer/{id}', name: 'app_deletePlayersInternship')]
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
// modify an internship (admin only)
   #[Route('/entraineur/Leclub/Stages/modifier/{id}', name: 'app_modifyInternship')]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('ROLE_ENTRAINEUR')]
  public function app_modifyInternship(Request $request, EntityManagerInterface $em, $id, InternshipsRepository $ir): Response
    {
      

        $internship = $em->getRepository(Internships::class)->find($id);

        $form = $this->createForm(InternshipCreationType::class, $internship);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {   
        $em-> flush();

            $this->addFlash('success', 'Stage mis à jour avec succès !');          
            return $this->redirectToRoute('app_internships');
        } 

        if($form->isSubmitted()&& !$form->isValid())
        {   
         $this->addFlash('error', 'Erreur dans la mise à jour, celle ci n\'est pas prise en compte');
        }
         return $this->render("admin/createInternship.html.twig", [
            "form" => $form,
            
        ]);
     }
#[Route('/admin/Leclub/Stages/suppression/{id}', name: 'app_deleteInternship')]
    #[IsGranted('ROLE_ADMIN')]
   public function app_deleteInternship(int $id, InternshipsRepository $ir, EntityManagerInterface $em, Request $request) : Response
    {

         //get the internship clicked on
        $internship = $ir->find($id);

         // token check 
        $token = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('delete_Internship_' . $internship->getId(), $token)) {
            $this->addFlash('error', 'Token invalide');
            return $this->redirectToRoute('app_internships');
        }

        $em->remove($internship);
        $em->flush();
        
        return $this->redirectToRoute('app_internships');
    }


}

