<?php

namespace App\Controller;

use App\Entity\Ejemplar;
use App\Form\EjemplarType;
use App\Repository\EjemplarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ejemplar')]
class EjemplarController extends AbstractController
{
    #[Route('/', name: 'app_ejemplar_index', methods: ['GET'])]
    public function index(EjemplarRepository $ejemplarRepository): Response
    {
        return $this->render('ejemplar/index.html.twig', [
            'ejemplars' => $ejemplarRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ejemplar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EjemplarRepository $ejemplarRepository): Response
    {
        $ejemplar = new Ejemplar();
        $form = $this->createForm(EjemplarType::class, $ejemplar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ejemplarRepository->save($ejemplar, true);

            return $this->redirectToRoute('app_ejemplar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ejemplar/new.html.twig', [
            'ejemplar' => $ejemplar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ejemplar_show', methods: ['GET'])]
    public function show(Ejemplar $ejemplar): Response
    {
        return $this->render('ejemplar/show.html.twig', [
            'ejemplar' => $ejemplar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ejemplar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ejemplar $ejemplar, EjemplarRepository $ejemplarRepository): Response
    {
        $form = $this->createForm(EjemplarType::class, $ejemplar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ejemplarRepository->save($ejemplar, true);

            return $this->redirectToRoute('app_ejemplar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ejemplar/edit.html.twig', [
            'ejemplar' => $ejemplar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ejemplar_delete', methods: ['POST'])]
    public function delete(Request $request, Ejemplar $ejemplar, EjemplarRepository $ejemplarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ejemplar->getId(), $request->request->get('_token'))) {
            $ejemplarRepository->remove($ejemplar, true);
        }

        return $this->redirectToRoute('app_ejemplar_index', [], Response::HTTP_SEE_OTHER);
    }
}
