<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use App\Repository\ZooArcadiaRepository;
use App\Repository\HabitatsRepository;
use App\Repository\ImageZooRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/animal', name: 'app_api_animal_')]
class AnimalController extends AbstractController
{
    private $repository;
    private $manager;
    private $zooArcadiaRepository;
    private $habitatsRepository;
    private $imageZooRepository;
    private $raceRepository;

    public function __construct(AnimalRepository $repository, EntityManagerInterface $entityManager, ZooArcadiaRepository $zooArcadiaRepository, HabitatsRepository $habitatsRepository, ImageZooRepository $imageZooRepository, RaceRepository $raceRepository)
    {
        $this->repository = $repository;
        $this->manager = $entityManager;
        $this->zooArcadiaRepository = $zooArcadiaRepository;
        $this->habitatsRepository = $habitatsRepository;
        $this->imageZooRepository = $imageZooRepository;
        $this->raceRepository = $raceRepository;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $animals = $this->repository->findAll();
        return $this->json($animals);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $animal = $this->repository->find($id);
        if (!$animal) {
            throw $this->createNotFoundException("Animal not found with id $id");
        }
        return $this->json($animal);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $animal = new Animal();

        
        $prenom = $request->request->get('prenom');
        $zooArcadiaId = $request->request->get('zooArcadia');
        $habitatId = $request->request->get('habitat');
        $imageZooId = $request->request->get('imageZoo');
        $raceId = $request->request->get('race');

        
        if (!$prenom || !$zooArcadiaId || !$habitatId || !$imageZooId || !$raceId) {
            return $this->json(['message' => 'Prenom, zooArcadia, habitat, imageZoo and race are required'], Response::HTTP_BAD_REQUEST);
        }


        $zooArcadia = $this->zooArcadiaRepository->find($zooArcadiaId);
        if (!$zooArcadia) {
            return $this->json(['message' => 'Invalid zooArcadia ID'], Response::HTTP_BAD_REQUEST);
        }

        $habitat = $this->habitatsRepository->find($habitatId);
        if (!$habitat) {
            return $this->json(['message' => 'Invalid habitat ID'], Response::HTTP_BAD_REQUEST);
        }

        $imageZoo = $this->imageZooRepository->find($imageZooId);
        if (!$imageZoo) {
            return $this->json(['message' => 'Invalid imageZoo ID'], Response::HTTP_BAD_REQUEST);
        }

        $race = $this->raceRepository->find($raceId);
        if (!$race) {
            return $this->json(['message' => 'Invalid race ID'], Response::HTTP_BAD_REQUEST);
        }

        
        $animal->setPrenom($prenom);
        $animal->setZooArcadia($zooArcadia);
        $animal->setHabitats($habitat);
        $animal->setImageZoo($imageZoo);
        $animal->setRace($race);
        $animal->setCreatedAt(new \DateTimeImmutable());

        
        $this->manager->persist($animal);
        $this->manager->flush();

        return $this->json(['message' => 'Animal created successfully', 'id' => $animal->getId()], Response::HTTP_CREATED);
    }


    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $animal = $this->repository->find($id);
        if (!$animal) {
            throw $this->createNotFoundException("Animal not found with id $id");
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['prenom'])) {
            $animal->setPrenom($data['prenom']);
        }

        if (isset($data['zooArcadia'])) {
            $zooArcadia = $this->zooArcadiaRepository->find($data['zooArcadia']);
            if (!$zooArcadia) {
                return $this->json(['message' => 'Invalid zooArcadia ID'], Response::HTTP_BAD_REQUEST);
            }
            $animal->setZooArcadia($zooArcadia);
        }

        if (isset($data['habitat'])) {
            $habitat = $this->habitatsRepository->find($data['habitat']);
            if (!$habitat) {
                return $this->json(['message' => 'Invalid habitat ID'], Response::HTTP_BAD_REQUEST);
            }
            $animal->setHabitats($habitat);
        }
        if (isset($data['race'])) {
            $race = $this->raceRepository->find($data['race']);
            if (!$race) {
                return $this->json(['message' => 'Invalid race ID'], Response::HTTP_BAD_REQUEST);
            }
            $animal->setRace($race);
        }

        $animal->setUpdatedAt(new \DateTimeImmutable());

        $this->manager->flush();

        return $this->json(['message' => 'Animal updated successfully']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $animal = $this->repository->find($id);
        if (!$animal) {
            throw $this->createNotFoundException("Animal not found with id $id");
        }

        $this->manager->remove($animal);
        $this->manager->flush();

        return $this->json(['message' => 'Animal deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
