<?php

namespace App\Controller;

use App\Entity\CarouselSlide;
use App\Form\CarouselSlideType;
use App\Repository\CarouselRepository;
use App\Repository\CarouselSlideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/carouselSlide', name: 'app_api_carouselSlide_')]
class CarouselSlideController extends AbstractController
{
    private $repository;
    private $carouselRepository;
    private $manager;

    public function __construct(CarouselSlideRepository $repository, CarouselRepository $carouselRepository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->carouselRepository = $carouselRepository;
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $slides = $this->repository->findAll();
        return $this->json($slides);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $slide = $this->repository->find($id);
        if (!$slide) {
            throw $this->createNotFoundException("Slide not found with id $id");
        }
        return $this->json($slide);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $slide = new CarouselSlide();
        $data = json_decode($request->getContent(), true);

        $carousel = $this->carouselRepository->find($data['carousel']);
        if (!$carousel) {
            return $this->json(['message' => 'Invalid carousel ID'], Response::HTTP_BAD_REQUEST);
        }

        $slide->setImageLarge($data['imageLarge']);
        $slide->setImageMedium($data['imageMedium']);
        $slide->setImageSmall($data['imageSmall']);
        $slide->setDescription($data['description']);
        $slide->setCarousel($carousel);

        $this->manager->persist($slide);
        $this->manager->flush();

        return $this->json(['message' => 'Slide created successfully', 'id' => $slide->getId()], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $slide = $this->repository->find($id);
        if (!$slide) {
            throw $this->createNotFoundException("Slide not found with id $id");
        }

        $form = $this->createForm(CarouselSlideType::class, $slide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->json(['message' => 'Slide updated successfully']);
        }

        return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $slide = $this->repository->find($id);
        if (!$slide) {
            throw $this->createNotFoundException("Slide not found with id $id");
        }

        $this->manager->remove($slide);
        $this->manager->flush();

        return $this->json(['message' => 'Slide deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
