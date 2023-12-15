<?php

namespace App\Controller;

use App\Entity\Culte;
use App\Form\CulteType;
use App\Repository\CulteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/culte')]
class CulteController extends AbstractController
{
    #[Route('/', name: 'app_culte_index', methods: ['GET'])]
    public function index(CulteRepository $culteRepository): Response
    {
        return $this->render('culte/index.html.twig', [
            'cultes' => $culteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_culte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $culte = new Culte();
        $form = $this->createForm(CulteType::class, $culte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($culte);
            $entityManager->flush();

            return $this->redirectToRoute('app_culte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('culte/new.html.twig', [
            'culte' => $culte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_culte_show', methods: ['GET'])]
    public function show(Culte $culte): Response
    {
        return $this->render('culte/show.html.twig', [
            'culte' => $culte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_culte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Culte $culte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CulteType::class, $culte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_culte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('culte/edit.html.twig', [
            'culte' => $culte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_culte_delete', methods: ['POST'])]
    public function delete(Request $request, Culte $culte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$culte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($culte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_culte_index', [], Response::HTTP_SEE_OTHER);
    }
}
