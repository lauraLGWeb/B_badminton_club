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
        dump($_ENV['MAILER_DSN'] ?? 'MAILER_DSN non défini !');

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        dump('📧 On entre dans le if !');

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

             error_log('===== DÉBUT ENVOI EMAIL =====');

            try {
                $email = (new Email())
                    ->from('laura.maglegall@gmail.com')
                    ->to('laura.maglegall@gmail.com')
                    ->subject('TEST Contact BBC')
                    ->text(sprintf(
                        "Prénom : %s\nNom : %s\nEmail : %s\n\nMessage :\n%s",
                        $data['firstName'],
                        $data['lastName'],
                        $data['email'],
                        $data['message']
                    ));

                  error_log('Email créé, on va l\'envoyer...');

                $mailer->send($email);
   
             error_log('✅ Email envoyé avec send()');
                
                $this->addFlash('success', '✅ Message envoyé avec succès !');
                
            } catch (\Exception $e) {
                error_log('❌ ERREUR : ' . $e->getMessage());
                error_log('Type : ' . get_class($e));

                // Afficher l'erreur complète
                $this->addFlash('error', '❌ ERREUR : ' . $e->getMessage());
            }
 error_log('===== FIN ENVOI EMAIL =====');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}










// namespace App\Controller;

// use App\Form\ContactType;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Attribute\Route;

// use Symfony\Component\Mime\Email;
// use Symfony\Component\Mailer\MailerInterface;

// class ContactController extends AbstractController
// {
//     #[Route('/contact', name: 'app_contact')]
//     public function contact(Request $request, MailerInterface $mailer): Response
//     {
//         // Créer un nouvel objet pour le formulaire
//         $form = $this->createForm(ContactType::class);

//         // Traiter la soumission du formulaire
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             // Si le formulaire est valide, récupérer les données
//             $data = $form->getData();
            
//             // Créer un email avec les données du formulaire
//             $email = (new Email())
//                 ->from('laura.maglegall@gmail.com')
//                 ->replyTo($data['email'])
//                 ->to('laura.maglegall@gmail.com')  // email club to receive user demand
//                 ->subject('Nouveau message de contact via le site ')
//                 ->text(sprintf(
//                "Message de : %s %s (%s)\n\n%s", //to know who's sending the request
//                 $data['lastName'],
//                 $data['firstName'],
//                 $data['email'],
//                 $data['message']
// ));

//             // Envoi de l'email
//             $mailer->send($email);

//             // Ajouter un message flash
//             $this->addFlash('success', 'Votre message a été envoyé avec succès.');

//             // Rediriger vers une autre page (par exemple, vers la même page)
//             return $this->redirectToRoute('app_contact');
//         }

//         // Afficher le formulaire dans la vue
//         return $this->render('contact/index.html.twig', [
//             'contactForm' => $form->createView(),
//         ]);
//     }
// }