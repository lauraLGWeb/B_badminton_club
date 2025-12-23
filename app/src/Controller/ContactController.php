<?php
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
        // Créer un nouvel objet pour le formulaire
        $form = $this->createForm(ContactType::class);

        // Traiter la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est valide, récupérer les données
            $data = $form->getData();
            
            // Créer un email avec les données du formulaire
            $email = (new Email())
                ->from($data['email'])
                ->to('contact@tonsite.com')  // Remplace par ton email
                ->subject('Nouveau message de contact')
                ->text($data['message']);

            // Envoi de l'email
            $mailer->send($email);

            // Ajouter un message flash
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Rediriger vers une autre page (par exemple, vers la même page)
            return $this->redirectToRoute('app_contact');
        }

        // Afficher le formulaire dans la vue
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}