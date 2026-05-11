<?php
// =====================
// form for user to make contact with the club 
// =====================
namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
    
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

             

            try {
                $email = (new Email())
                    ->from('bloisbadclub@gmail.com')
                    ->to('bloisbadclub@gmail.com')
                    ->subject('Contact BBC - Nouveau message depuis le site')
                    ->text(sprintf(
                        "Prénom : %s\nNom : %s\nEmail : %s\n\nMessage :\n%s",
                        $data['firstName'],
                        $data['lastName'],
                        $data['email'],
                        $data['message']
                    ));

                  

                $mailer->send($email);
   
             
                
                $this->addFlash('success', '✅ Message envoyé avec succès !');
                
            } catch (\Exception $e) {
                // Afficher l'erreur complète
                $this->addFlash('error', '❌ ERREUR : ' . $e->getMessage());
            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}






