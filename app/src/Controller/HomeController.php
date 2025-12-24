<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationFormType;
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
    #[Route('/Leclub/Membres', name: 'app_members')]
    public function members(): Response
    {
        return $this->render('home/CaMember.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

      #[Route('/Leclub/Entraineurs', name: 'app_coaches')]
    public function coaches(): Response
    {
        return $this->render('home/coaches.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


#[Route('/Leclub/Reglement', name: 'app_rules')]
    public function rules(): Response
    {
        return $this->render('home/rules.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

        #[Route('/Leclub/Stages', name: 'app_internships')]
    public function internships(): Response
    {
        return $this->render('home/internships.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


  #[Route('/Leclub/Membres/compte', name: 'app_account')]
    public function account(): Response
    {
        return $this->render('home/account.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
     
  
// routes for the ecole de bad dropdown
    // #[Route('/Leclub/Membres', name: 'app_members')]
    // public function members(): Response
    // {
    //     return $this->render('home/CaMember.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

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
        return $this->render('home/prices.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


     #[Route('/Actualites', name: 'app_actuality')]
    public function actuality(): Response
    {
        return $this->render('home/actuality.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

       #[Route('/Partenaires', name: 'app_partners')]
    public function partners(): Response
    {
        return $this->render('home/partners.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

       #[Route('/Boutique', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('home/shop.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


          #[Route('/Creneaux', name: 'app_schedules')]
    public function schedules(): Response
    {
        return $this->render('home/schedules.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

        #[Route('/Essais', name: 'app_try')]
    public function try(): Response
    {
        return $this->render('home/try.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
      #[Route('/admin', name: 'app_admin_dashboard')]
    public function adminDash(): Response
    {
        return $this->render('home/adminDashboard.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


// pages for internship
     #[Route('/Leclub/Stages/gestion', name: 'app_each_intership')]
    public function eachInternship(): Response
    {
        return $this->render('home/eachInternship.html.twig', [
            'controller_name' => 'HomeController',
        ]);
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

        $formulaire = $this->createForm(RegistrationFormType::class, $user);

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted()&& $formulaire->isValid())
        {
           $em-> flush();
            
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