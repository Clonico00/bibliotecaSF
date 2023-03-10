<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use App\Repository\PrestamoRepository;
use App\Repository\SocioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/socio')]
class SocioController extends AbstractController
{
    #[Route('/', name: 'app_socio_index', methods: ['GET'])]
    public function index(SocioRepository $socioRepository): Response
    {
        return $this->render('socio/index.html.twig', [
            'socios' => $socioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_socio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocioRepository $socioRepository): Response
    {
        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socioRepository->save($socio, true);

            return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('socio/new.html.twig', [
            'socio' => $socio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_socio_show', methods: ['GET'])]
    public function show(Socio $socio): Response
    {
        return $this->render('socio/show.html.twig', [
            'socio' => $socio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_socio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Socio $socio, SocioRepository $socioRepository): Response
    {
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socioRepository->save($socio, true);

            return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('socio/edit.html.twig', [
            'socio' => $socio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_socio_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio, SocioRepository $socioRepository, PrestamoRepository $prestamoRepository): Response
    {
        $prestamos = $prestamoRepository->findBy(['socio' => $socio]);

        if (!empty($prestamos)) {
            $this->addFlash('error', 'No se puede eliminar el socio porque tiene pr??stamos asociados.');
            return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isCsrfTokenValid('delete'.$socio->getId(), $request->request->get('_token'))) {
            $socioRepository->remove($socio, true);
        }

        return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
    }


}
