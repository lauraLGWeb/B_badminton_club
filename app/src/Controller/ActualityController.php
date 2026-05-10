<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Repository\ActualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ActualityType;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ActualityController extends AbstractController
{
    #[Route('/Actualites', name: 'app_actuality')]
    public function actuality(ActualityRepository $actualityRepository): Response
    {
        $actualities = $actualityRepository->findBy([], ['eventOn' => 'DESC']);

        return $this->render('home/actuality.html.twig', [
            'actualities' => $actualities,
        ]);
    }

    #[Route('/Actualites/detail/{id}', name: 'app_actualityDetail')]
    public function actualitydetail(ActualityRepository $actualityRepository, int $id): Response
    {
        $actuality = $actualityRepository->find($id);

        return $this->render('home/actualityDetail.html.twig', [
            'actuality' => $actuality,
        ]);
    }

    #[Route('/admin/Actualites/création', name: 'app_createActuality')]
    #[IsGranted('ROLE_ADMIN')]
    public function createActuality(Request $request, EntityManagerInterface $em): Response
    {
        $newActu = new Actuality();
        $form = $this->createForm(ActualityType::class, $newActu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newActu->setCreatedAt(new \DateTimeImmutable());
            $em->persist($newActu);
            $em->flush();

            $this->addFlash('success', 'Actualité créée avec succès !');
            return $this->redirectToRoute('app_actuality');
        }

        return $this->render('admin/createActuality.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/Actualites/modifier/{id}', name: 'app_modifyActuality')]
    #[IsGranted('ROLE_ADMIN')]
    public function modifyActuality(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $actu = $em->getRepository(Actuality::class)->find($id);

        $formulaire = $this->createForm(ActualityType::class, $actu);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Actualité mise à jour avec succès !');
            return $this->redirectToRoute('app_actuality');
        }

        return $this->render('admin/createActuality.html.twig', [
            'form' => $formulaire,
        ]);
    }

    #[Route('/admin/Actualites/suppression/{id}', name: 'app_deleteActuality')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteActuality(Request $request, EntityManagerInterface $em, int $id): Response
    {
        if (!$this->isCsrfTokenValid('delete_actuality_' . $id, $request->request->get('_token'))) {
            throw new InvalidCsrfTokenException();
        }

        $actuality = $em->getRepository(Actuality::class)->find($id);
        $em->remove($actuality);
        $em->flush();

        $this->addFlash('success', 'Actualité supprimée avec succès !');
        return $this->redirectToRoute('app_actuality');
    }
}