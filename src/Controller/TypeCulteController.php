<?php

namespace App\Controller;

use App\Entity\TypeCulte;
use App\Form\TypeCulteType;
use App\Repository\TypeCulteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/culte')]
class TypeCulteController extends AbstractController
{
    #[Route('/', name: 'app_type_culte_index', methods: ['GET'])]
    public function index(TypeCulteRepository $typeCulteRepository): Response
    {
        return $this->render('type_culte/index.html.twig', [
            'type_cultes' => $typeCulteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_culte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeCulte = new TypeCulte();
        $form = $this->createForm(TypeCulteType::class, $typeCulte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeCulte);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_culte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_culte/new.html.twig', [
            'type_culte' => $typeCulte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_culte_show', methods: ['GET'])]
    public function show(TypeCulte $typeCulte): Response
    {
        return $this->render('type_culte/show.html.twig', [
            'type_culte' => $typeCulte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_culte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeCulte $typeCulte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeCulteType::class, $typeCulte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_culte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_culte/edit.html.twig', [
            'type_culte' => $typeCulte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_culte_delete', methods: ['POST'])]
    public function delete(Request $request, TypeCulte $typeCulte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeCulte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeCulte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_culte_index', [], Response::HTTP_SEE_OTHER);
    }
}
