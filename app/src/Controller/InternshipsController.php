<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\InternshipsRepository;

final class InternshipsController extends AbstractController
{
    #[Route('/Leclub/Stages', name: 'app_internships')]
    public function internships(InternshipsRepository $ir): Response
    {
          $internships = $ir->findAll();

        return $this->render('internships/index.html.twig', [
            'internships' => $internships,
        ]);

    }
}
