<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/images')]
class ImagesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'images_index', methods: ['GET'])]
    public function index(): Response
    {
        $images = $this->entityManager->getRepository(Images::class)->findAll();

        return $this->json($images);
    }

    #[Route('/new', name: 'images_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $image = new Images();
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($image);
            $this->entityManager->flush();

            return $this->redirectToRoute('images_index');
        }

        return $this->render('images/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'images_show', methods: ['GET'])]
    public function show(Images $image): Response
    {
        return $this->render('images/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Images $image): Response
    {
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('images_index');
        }

        return $this->render('images/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'images_delete', methods: ['POST'])]
    public function delete(Request $request, Images $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($image);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('images_index');
    }
}
