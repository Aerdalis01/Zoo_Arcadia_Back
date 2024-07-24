<?php

namespace App\Controller;

use App\Entity\Carousel;
use App\Entity\CarouselSlide;
use App\Form\CarouselType;
use App\Repository\CarouselRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/carousel', name: 'app_api_carousel_')]
class CarouselController extends AbstractController
{
    private $repository;
    private $manager;

    public function __construct(CarouselRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $carousels = $this->repository->findAll();
        return $this->json($carousels);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $carousel = $this->repository->find($id);
        if (!$carousel) {
            throw $this->createNotFoundException("Carousel not found with id $id");
        }
        return $this->json($carousel);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $carousel = new Carousel();
        $data = json_decode($request->getContent(), true);

        foreach ($data['carouselSlides'] as $slideData) {
            $carouselSlide = new CarouselSlide();
            $carouselSlide->setImageLarge($slideData['imageLarge']);
            $carouselSlide->setImageMedium($slideData['imageMedium']);
            $carouselSlide->setImageSmall($slideData['imageSmall']);
            $carouselSlide->setDescription($slideData['description']);
            $carouselSlide->setCarousel($carousel);
            $carousel->addCarouselSlide($carouselSlide);
        }

        $this->manager->persist($carousel);
        $this->manager->flush();

        return $this->json(['message' => 'Carousel created successfully', 'id' => $carousel->getId()], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $carousel = $this->repository->find($id);
        if (!$carousel) {
            throw $this->createNotFoundException("Carousel not found with id $id");
        }

        $data = json_decode($request->getContent(), true);

        foreach ($carousel->getCarouselSlides() as $carouselSlide) {
            $carousel->removeCarouselSlide($carouselSlide);
            $this->manager->remove($carouselSlide);
        }

        foreach ($data['carouselSlides'] as $slideData) {
            $carouselSlide = new CarouselSlide();
            $carouselSlide->setImageLarge($slideData['imageLarge']);
            $carouselSlide->setImageMedium($slideData['imageMedium']);
            $carouselSlide->setImageSmall($slideData['imageSmall']);
            $carouselSlide->setDescription($slideData['description']);
            $carouselSlide->setCarousel($carousel);
            $carousel->addCarouselSlide($carouselSlide);
        }

        $this->manager->persist($carousel);
        $this->manager->flush();

        return $this->json(['message' => 'Carousel updated successfully']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $carousel = $this->repository->find($id);
        if (!$carousel) {
            throw $this->createNotFoundException("Carousel not found with id $id");
        }

        // Dissocier le carousel des entités ZooArcadia
        $zooArcadias = $carousel->getZooArcadia();
        if ($zooArcadias) {
            foreach ($zooArcadias as $zooArcadia) {
                $zooArcadia->setCarousel(null);
            }
        }

        // Suppression des slides du carousel
        $carouselSlides = $carousel->getCarouselSlides();
        if ($carouselSlides) {
            foreach ($carouselSlides as $carouselSlide) {
                $this->manager->remove($carouselSlide);
            }
        }

        $this->manager->remove($carousel);
        $this->manager->flush();

        return $this->json(['message' => 'Carousel and related slides deleted successfully'], Response::HTTP_NO_CONTENT);
    }
    

    #[Route('/{id}/add-slides', name: 'add_slides', methods: ['POST'])]
    public function addSlides(int $id, Request $request): Response
    {
        $carousel = $this->repository->find($id);
        if (!$carousel) {
            throw $this->createNotFoundException("Carousel not found with id $id");
        }

        $data = json_decode($request->getContent(), true);

        foreach ($data['carouselSlides'] as $slideData) {
            $carouselSlide = new CarouselSlide();
            $carouselSlide->setImageLarge($slideData['imageLarge']);
            $carouselSlide->setImageMedium($slideData['imageMedium']);
            $carouselSlide->setImageSmall($slideData['imageSmall']);
            $carouselSlide->setDescription($slideData['description']);
            $carouselSlide->setCarousel($carousel);
            $carousel->addCarouselSlide($carouselSlide);
        }

        $this->manager->persist($carousel);
        $this->manager->flush();

        return $this->json(['message' => 'Slides added successfully']);
    }
}
