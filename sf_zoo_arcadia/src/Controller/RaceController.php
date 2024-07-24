<?php

namespace App\Controller;

use App\Entity\Race;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/race', name: 'app_api_race_')]
class RaceController extends AbstractController
{
    private $repository;
    private $manager;

    public function __construct(RaceRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $races = $this->repository->findAll();
        return $this->json($races);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $race = $this->repository->find($id);
        if (!$race) {
            throw $this->createNotFoundException("Race not found with id $id");
        }
        return $this->json($race);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $race = new Race();
        $race->setNom($request->request->get('nom'));

        $this->manager->persist($race);
        $this->manager->flush();

        return $this->json(['message' => 'Race created successfully', 'id' => $race->getId()], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $race = $this->repository->find($id);
        if (!$race) {
            throw $this->createNotFoundException("Race not found with id $id");
        }

        $data = json_decode($request->getContent(), true);
        $race->setNom($data['nom'] ?? $race->getNom());

        $this->manager->flush();
        return $this->json(['message' => 'Race updated successfully']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $race = $this->repository->find($id);
        if (!$race) {
            throw $this->createNotFoundException("Race not found with id $id");
        }

        $this->manager->remove($race);
        $this->manager->flush();

        return $this->json(['message' => 'Race deleted successfully'], Response::HTTP_NO_CONTENT);
    }

}
