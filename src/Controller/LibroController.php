<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Form\LibroType;
use App\Repository\EjemplarRepository;
use App\Repository\LibroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/libros", name="app_libros")
 * @IsGranted("ROLE_USER")
 */
#[Route('/libro')]
class LibroController extends AbstractController
{
    #[Route('/', name: 'app_libro_index', methods: ['GET'])]
    public function index(LibroRepository $libroRepository): Response
    {
        return $this->render('libro/index.html.twig', [
            'libros' => $libroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_libro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LibroRepository $libroRepository): Response
    {
        $libro = new Libro();
        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $libroRepository->save($libro, true);

            return $this->redirectToRoute('app_libro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('libro/new.html.twig', [
            'libro' => $libro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_show', methods: ['GET'])]
    public function show(Libro $libro): Response
    {
        return $this->render('libro/show.html.twig', [
            'libro' => $libro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_libro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Libro $libro, LibroRepository $libroRepository): Response
    {
        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $libroRepository->save($libro, true);

            return $this->redirectToRoute('app_libro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('libro/edit.html.twig', [
            'libro' => $libro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_libro_delete', methods: ['POST'])]
    public function delete(Request $request, Libro $libro, EjemplarRepository $ejemplarRepository,EntityManagerInterface $entityManager): Response
    {
        // Buscar los ejemplares asociados al libro
        $ejemplares = $ejemplarRepository->findBy(['libro' => $libro]);

        //si tiene ejemplares no se puede borrar

        if ($ejemplares) {
            $this->addFlash('error', 'El libro no se puede borrar porque tiene ejemplares asociados.');
            return $this->redirectToRoute('app_libro_index');
        }

        $entityManager->remove($libro);
        $entityManager->flush();

        $this->addFlash('success', 'El libro ha sido borrado.');

        return $this->redirectToRoute('app_libro_index');
    }



}
