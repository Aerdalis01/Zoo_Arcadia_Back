<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Repository\HabitatsRepository;
use App\Repository\ImageZooRepository;
use App\Repository\ZooArcadiaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/habitats', name: 'app_api_habitats_')]
class HabitatsController extends AbstractController
{
    private $repository;
    private $imageRepository;
    private $zooRepository;
    private $manager;

    public function __construct(
        HabitatsRepository $repository,
        ImageZooRepository $imageRepository,
        ZooArcadiaRepository $zooRepository,
        EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->zooRepository = $zooRepository;
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $habitats = $this->repository->findAll();
        return $this->json($habitats);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $habitat = $this->repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => "Aucun habitat trouvé pour l'id {$id}"], Response::HTTP_NOT_FOUND);
        }

        return $this->json($habitat);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $nom = $request->request->get('nom');
        $description = $request->request->get('description');
        $imageId = $request->request->get('imageId');
        $zooArcadiaId = $request->request->get('zooArcadiaId');

        if (!$nom) {
            return $this->json(['message' => 'Le nom est requis'], Response::HTTP_BAD_REQUEST);
        }

        if (!$zooArcadiaId) {
            return $this->json(['message' => 'Le zooArcadiaId est requis'], Response::HTTP_BAD_REQUEST);
        }

        $habitat = new Habitats();
        $habitat->setNom($nom);
        $habitat->setDescription($description);
        $habitat->setCreatedAt(new \DateTimeImmutable());

        $zooArcadia = $this->zooRepository->find($zooArcadiaId);
        if (!$zooArcadia) {
            return $this->json(['message' => 'ZooArcadia non trouvé'], Response::HTTP_BAD_REQUEST);
        }

        $habitat->setZooArcadia($zooArcadia);

        if ($imageId) {
            $image = $this->imageRepository->find($imageId);
            if ($image) {
                $habitat->setImageZoo($image);
            }
        }

        $this->manager->persist($habitat);
        $this->manager->flush();

        return $this->json(
            ['message' => "Habitat créé avec succès avec l'id {$habitat->getId()}"],
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): Response
    {
        $habitat = $this->repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => "Aucun habitat trouvé pour l'id {$id}"], Response::HTTP_NOT_FOUND);
        }

        $nom = $request->request->get('nom');
        $description = $request->request->get('description');
        $imageId = $request->request->get('imageId');
        $zooArcadiaId = $request->request->get('zooArcadiaId');

        if ($nom) {
            $habitat->setNom($nom);
        }

        if ($description) {
            $habitat->setDescription($description);
        }

        if ($zooArcadiaId) {
            $zooArcadia = $this->zooRepository->find($zooArcadiaId);
            if ($zooArcadia) {
                $habitat->setZooArcadia($zooArcadia);
            }
        }

        if ($imageId) {
            $image = $this->imageRepository->find($imageId);
            if ($image) {
                $habitat->setImageZoo($image);
            }
        }

        $this->manager->persist($habitat);
        $this->manager->flush();

        return $this->json(['message' => 'Habitat mis à jour avec succès']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $habitat = $this->repository->find($id);

        if (!$habitat) {
            return $this->json(['message' => "Aucun habitat trouvé pour l'id {$id}"], Response::HTTP_NOT_FOUND);
        }

        $this->manager->remove($habitat);
        $this->manager->flush();

        return $this->json(['message' => 'Habitat supprimé avec succès']);
    }
}
