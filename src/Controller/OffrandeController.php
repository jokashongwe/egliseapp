<?php

namespace App\Controller;

use App\Entity\Offrande;
use App\Form\OffrandeType;
use App\Repository\CulteRepository;
use App\Repository\OffrandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offrande')]
class OffrandeController extends AbstractController
{
    #[Route('/', name: 'app_offrande_index', methods: ['GET'])]
    public function index(OffrandeRepository $offrandeRepository): Response
    {
        return $this->render('offrande/index.html.twig', [
            'offrandes' => $offrandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offrande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offrande = new Offrande();
        $form = $this->createForm(OffrandeType::class, $offrande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offrande);
            $entityManager->flush();

            return $this->redirectToRoute('app_offrande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offrande/new.html.twig', [
            'offrande' => $offrande,
            'form' => $form,
        ]);
    }

    #[Route('/culte/{id}', name: 'app_offrande_culte', methods: ['GET'])]
    public function offrande_culte($id, CulteRepository $culteRepository): Response
    {
        $culte = $culteRepository->find($id);
        if(is_null($culte)){
            return $this->redirectToRoute("app_offrande_index"); 
        }
        $offrandes = $culte->getOffrandes();
        return $this->render('offrande/index.html.twig', [
            'offrandes' => $offrandes,
        ]);
    }


    #[Route('/{id}', name: 'app_offrande_show', methods: ['GET'])]
    public function show(Offrande $offrande): Response
    {
        return $this->render('offrande/show.html.twig', [
            'offrande' => $offrande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offrande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offrande $offrande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffrandeType::class, $offrande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offrande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offrande/edit.html.twig', [
            'offrande' => $offrande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offrande_delete', methods: ['POST'])]
    public function delete(Request $request, Offrande $offrande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offrande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offrande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offrande_index', [], Response::HTTP_SEE_OTHER);
    }
}
