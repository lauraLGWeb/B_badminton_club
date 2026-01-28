<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use App\Entity\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\Actualities;
use App\Form\ArticleType;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ModifyContactType;
use App\Form\UserModify;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class HomeController extends AbstractController
{
       #[Route('/', name: 'app_home')]
    public function index(DocumentManager $dm): Response
    {
        //get all the actualities
        $actualities = $dm->getRepository(Actualities::class)->findBy([], ['eventOn' => 'DESC'], 2);
       
        
        return $this->render('home/index.html.twig', [
            'actualities' => $actualities,
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


       #[Route('/Partenaires', name: 'app_partners')]
    public function partners(): Response
    {
        return $this->render('home/partners.html.twig');
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

  #[Route('/membre/Leclub/Membres/compte', name: 'app_account')]
   #[IsGranted('ROLE_MEMBRE')]
    public function account(): Response
    {
        return $this->render('home/account.html.twig');
    }
     


      #[Route('/admin', name: 'app_admin_dashboard')]
       #[IsGranted('ROLE_ADMIN')]
    public function adminDash(): Response
    {
        return $this->render('home/adminDashboard.html.twig');
    }


       #[Route('/admin/Liste-boutique', name: 'app_ItemsList')]
    #[IsGranted('ROLE_ADMIN')]
    public function ItemsList(ProductRepository $ProductRepository): Response
    {
         $product = $ProductRepository->findAll();

        return $this->render('admin/itemsList.html.twig', [
            'products' => $product,
        ]);
    }




       #[Route('/mentions', name: 'app_legalMentions')]
    public function legalMentions(): Response
    {
        return $this->render('legal/legalMentions.html.twig');
    }



// pages for internship
     #[Route('/Leclub/Stages/gestion', name: 'app_each_intership')]
      #[IsGranted('ROLE_ENTRAINEUR')]
    public function eachInternship(): Response
    {
        return $this->render('home/eachInternship.html.twig');
    }
      









    //======================
    //======================
    //pages for the admins
    //======================
    //======================


    //======================
    //FOR USER 
    //======================


    // get all the members who has an account online
     #[Route('/admin/membres/liste', name: 'app_membersList')]
     #[IsGranted('ROLE_ADMIN')]
    public function membersList(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(User::class);
        $user = $repo->findAll();


        return $this->render("admin/membersList.html.twig", ["user" => $user]);
    }           


        //modify the User
    #[Route('/admin/membres/modifier/{id}', name: 'app_modify')]
    #[IsGranted('ROLE_ADMIN')]
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
    #[IsGranted('ROLE_ADMIN')]
   public function supprimer(EntityManagerInterface $em, $id) : Response
    {

        //get the user connected
        $actualUser = $this->getUser();

        $repo = $em->getRepository(User::class);
        $user = $repo->find($id);


        // if i'm connected, i cannot delete my own account
        if($actualUser === $user){
            $this->addFlash('erreur', ' Attention Tu ne peux pas supprimer ton propre compte!');
            return $this->redirectToRoute('app_membersList');
        } 

        $em->remove($user);
        $em->flush();
        
        return $this->redirectToRoute('app_membersList');
    }



     //======================
    //FOR Shop 
    //======================

// create the shopitem 
      #[Route('/admin/Liste-boutique/ajouter', name: 'app_AddItemsList')]
    #[IsGranted('ROLE_ADMIN')]
    public function AddItemsList(Request $request, EntityManagerInterface $em ): Response
    {
        $newItemForm = new Product();
        $form = $this->createForm(ArticleType::class, $newItemForm);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
                          
            $em->persist($newItemForm);
            $em->flush();        

            $this->addFlash('success', 'Produit créée avec succès !');
            return $this->redirectToRoute('app_ItemsList');
            }
        
         return $this->render('admin/CreateItem.html.twig', [
          'form' => $form,
           ]);
    }

 //modify the shopitem
    #[Route('/admin/Liste-boutique/modifier/{id}', name: 'app_modifyItem')]
    #[IsGranted('ROLE_ADMIN')]
    public function app_modifyItem(Request $request, EntityManagerInterface $em, $id): Response
    {

        
        $item = $em->getRepository(Product::class)->find($id);

        $formulaire = $this->createForm(ArticleType::class, $item);

        

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted()&& $formulaire->isValid())
        {   
        $em-> flush();

             $this->addFlash('success', 'Produit mis à jour avec succès !');          
            return $this->redirectToRoute('app_ItemsList');
        } 

        if($formulaire->isSubmitted()&& !$formulaire->isValid())
        {   
         $this->addFlash('error', 'Erreur dans la mise à jour, celle ci n\'est pas prise en compte');
        }
         return $this->render("admin/CreateItem.html.twig", ["form" => $formulaire]);
     }



    //delete the shopitem
    #[Route('/admin/Liste-boutique/suppression/{id}', name: 'app_deleteProduct')]
    #[IsGranted('ROLE_ADMIN')]
    public function eleteItem(EntityManagerInterface $em, $id): Response
    {

        //getting the actuality details
        $itemToDelete = $em->getRepository(Product::class)->find($id);
        
        $em->remove($itemToDelete);
        $em->flush();

        $this->addFlash('success', 'Article supprimée avec succès !');

       return $this->redirectToRoute('app_ItemsList');
    }


}
