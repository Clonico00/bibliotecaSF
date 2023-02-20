<?php

namespace App\Controller;

use App\Entity\Ejemplar;
use App\Entity\Prestamo;
use App\Form\PrestamoType;
use App\Repository\PrestamoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/libros", name="app_libros")
 * @IsGranted("ROLE_USER")
 */
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
    public function new(Request $request, PrestamoRepository $prestamoRepository,EntityManagerInterface $entityManager): Response
    {
        $prestamo = new Prestamo();
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prestamoRepository->save($prestamo, true);

            // Obtener el ID del ejemplar asociado al préstamo
            $ejemplarId = $form->get('ejemplar')->getData()->getId();

            $ejemplar = $entityManager->getRepository(Ejemplar::class)->find($ejemplarId);

            // Actualizar el estado del ejemplar a "prestado"
            $ejemplar->setEstado('prestado');
            $entityManager->flush();

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
    public function delete(Request $request, Prestamo $prestamo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestamo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prestamo);

            // Obtener el ID del ejemplar asociado al préstamo
            $ejemplarId = $prestamo->getEjemplar()->getId();

            $ejemplar = $entityManager->getRepository(Ejemplar::class)->find($ejemplarId);

            // Actualizar el estado del ejemplar a "disponible"
            $ejemplar->setEstado('disponible');
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prestamo_index', [], Response::HTTP_SEE_OTHER);
    }


}
