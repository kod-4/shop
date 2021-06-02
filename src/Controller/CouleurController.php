<?php

namespace App\Controller;

use App\Entity\Couleur;
use App\Form\CouleurType;
use App\Repository\CouleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouleurController extends AbstractController
{
    #[Route('/admin/couleur', name: 'couleur_index', methods: ['GET'])]
    public function index(CouleurRepository $couleurRepository): Response
    {
        return $this->render('couleur/index.html.twig', [
            'couleurs' => $couleurRepository->findAll(),
        ]);
    }

    #[Route('/admin/couleur/new', name: 'couleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $couleur = new Couleur();
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($couleur);
            $entityManager->flush();

            return $this->redirectToRoute('couleur_index');
        }

        return $this->render('couleur/new.html.twig', [
            'couleur' => $couleur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/couleur/{id}', name: 'couleur_show', methods: ['GET'])]
    public function show(Couleur $couleur): Response
    {
        return $this->render('couleur/show.html.twig', [
            'couleur' => $couleur,
        ]);
    }

    #[Route('/admin/couleur/{id}/edit', name: 'couleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Couleur $couleur): Response
    {
        $form = $this->createForm(CouleurType::class, $couleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('couleur_index');
        }

        return $this->render('couleur/edit.html.twig', [
            'couleur' => $couleur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/couleur/{id}', name: 'couleur_delete', methods: ['POST'])]
    public function delete(Request $request, Couleur $couleur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$couleur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($couleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('couleur_index');
    }
}
