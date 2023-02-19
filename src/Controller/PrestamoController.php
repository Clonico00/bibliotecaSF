<?php

namespace App\Controller;

use App\Entity\Prestamo;
use App\Form\PrestamoType;
use App\Repository\PrestamoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/prestamo')]
class PrestamoController extends AbstractController
{
    #[Route('/', name: 'app_prestamo_index', methods: ['GET'])]
    public function index(PrestamoRepository $prestamoRepository): Response
    {
        return $this->render('prestamo/index.html.twig', [
            'prestamos' => $prestamoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prestamo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PrestamoRepository $prestamoRepository): Response
    {
        $prestamo = new Prestamo();
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prestamoRepository->save($prestamo, true);

            return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prestamo/new.html.twig', [
            'prestamo' => $prestamo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prestamo_show', methods: ['GET'])]
    public function show(Prestamo $prestamo): Response
    {
        return $this->render('prestamo/show.html.twig', [
            'prestamo' => $prestamo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prestamo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prestamo $prestamo, PrestamoRepository $prestamoRepository): Response
    {
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prestamoRepository->save($prestamo, true);

            return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prestamo/edit.html.twig', [
            'prestamo' => $prestamo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prestamo_delete', methods: ['POST'])]
    public function delete(Request $request, Prestamo $prestamo, PrestamoRepository $prestamoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestamo->getId(), $request->request->get('_token'))) {
            $prestamoRepository->remove($prestamo, true);
        }

        return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
    }
}
