<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\ModifyContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserModify;

final class HomeController extends AbstractController
{
       #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
   }




// routes for the club dropdown
  
      #[Route('/Leclub/Entraineurs', name: 'app_coaches')]
    public function coaches(): Response
    {
        return $this->render('home/coaches.html.twig');
    }

    #[Route('/Leclub/Membres', name: 'app_caMembers')]
    public function caMembers(): Response
    {
        return $this->render('home/caMembers.html.twig');
    }

#[Route('/Leclub/Reglement', name: 'app_rules')]
    public function rules(): Response
    {
        return $this->render('home/rules.html.twig');
    }

        #[Route('/Leclub/Stages', name: 'app_internships')]
    public function internships(): Response
    {
        return $this->render('home/internships.html.twig');
    }


  #[Route('/Leclub/Membres/compte', name: 'app_account')]
    public function account(): Response
    {
        return $this->render('home/account.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
     
  
// routes for the ecole de bad dropdown
 

    //   #[Route('/Leclub/Entraineurs', name: 'app_coaches')]
    // public function coaches(): Response
    // {
    //     return $this->render('home/coaches.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    //    #[Route('/Leclub/Reglement', name: 'app_rules')]
    // public function rules(): Response
    // {
    //     return $this->render('home/rules.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    //     #[Route('/Leclub/Stages', name: 'app_internships')]
    // public function internships(): Response
    // {
    //     return $this->render('home/internships.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

     #[Route('/Tarifs', name: 'app_prices')]
    public function prices(): Response
    {
        return $this->render('home/prices.html.twig');
    }


     #[Route('/Actualites', name: 'app_actuality')]
    public function actuality(): Response
    {
        return $this->render('home/actuality.html.twig');
    }

       #[Route('/Partenaires', name: 'app_partners')]
    public function partners(): Response
    {
        return $this->render('home/partners.html.twig');
    }

       #[Route('/Boutique', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('home/shop.html.twig');
    }

       #[Route('/Inscription', name: 'app_inscription')]
    public function Inscription(): Response
    {
        return $this->render('home/inscription.html.twig');
    }


          #[Route('/Creneaux', name: 'app_schedules')]
    public function schedules(): Response
    {
        return $this->render('home/schedules.html.twig');
    }

        #[Route('/Essais', name: 'app_try')]
    public function try(): Response
    {
        return $this->render('home/try.html.twig');
    }
      #[Route('/admin', name: 'app_admin_dashboard')]
    public function adminDash(): Response
    {
        return $this->render('home/adminDashboard.html.twig');
    }

       #[Route('/mentions', name: 'app_legalMentions')]
    public function legalMentions(): Response
    {
        return $this->render('legal/legalMentions.html.twig');
    }



// pages for internship
     #[Route('/Leclub/Stages/gestion', name: 'app_each_intership')]
    public function eachInternship(): Response
    {
        return $this->render('home/eachInternship.html.twig');
    }
      
    //======================
    //pages for the admins
    //======================


    // get all the members who has an account online
     #[Route('/admin/membres/liste', name: 'app_membersList')]
    public function membersList(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(User::class);
        $user = $repo->findAll();


        return $this->render("admin/membersList.html.twig", ["user" => $user]);
    }           


        //modify the User
    #[Route('/admin/membres/modifier/{id}', name: 'app_modify')]
   public function modify(Request $request, EntityManagerInterface $em, $id)
    {

        $user = $em->getRepository(User::class)->find($id);

        $formulaire = $this->createForm(ModifyContactType::class, $user);

        //give member role if no role, and take the role if there is, to put in in the form
         if (isset($user->getRoles()[0])) {
                $currentStatus = $user->getRoles()[0];
        } else {
                $currentStatus = 'ROLE_MEMBER';
        }

        //get the actual role 
         $formulaire->get('roles')->setData($currentStatus);

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted()&& $formulaire->isValid())
        {

         //set up the new role into the database
        $statut = $formulaire->get('roles')->getData();
        $user->setRoles([$statut]);


        $em-> flush();
                  
            return $this->redirectToRoute('app_membersList');
           
           
        } 

         return $this->render("admin/modify.html.twig", ["formulaire" => $formulaire]);
     }


    //delete the User
    #[Route('/admin/membres/supprimer/{id}', name: 'app_delete')]
   public function supprimer(EntityManagerInterface $em, $id) : Response
    {

        $repo = $em->getRepository(User::class);
        $user = $repo->find($id);

        $em->remove($user);
        $em->flush();
        
        return $this->redirectToRoute('app_membersList');
    }

}