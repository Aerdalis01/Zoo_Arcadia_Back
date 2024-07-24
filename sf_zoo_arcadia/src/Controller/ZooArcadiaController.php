<?php

namespace App\Controller;

use App\Entity\ZooArcadia;
use App\Entity\Carousel;
use App\Repository\ZooArcadiaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/zooArcadia', name: 'app_api_zooArcadia_')]
class ZooArcadiaController extends AbstractController
{
    private $repository;
    private $manager;

    public function __construct(ZooArcadiaRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->manager = $entityManager;
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $zooArcadia = new ZooArcadia();
        $carousel = new Carousel();

        $nom = $request->request->get('nom', 'Default Name');
        $adresse = $request->request->get('adresse', 'Default Address');
        $description = $request->request->get('description', 'Default Description');

        $zooArcadia->setNom($nom);
        $zooArcadia->setAdresse($adresse);
        $zooArcadia->setDescription($description);
        $zooArcadia->setCreatedAt(new \DateTimeImmutable());
        $zooArcadia->setCarousel($carousel);

        $this->manager->persist($zooArcadia);
        $this->manager->persist($carousel);
        $this->manager->flush();

        return $this->json(
            ['message' => "ZooArcadia resource created with ID {$zooArcadia->getId()}"],
            status: Response::HTTP_CREATED,
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $zooArcadia = $this->repository->findOneBy(['id' => $id]);

        if (!$zooArcadia) {
            throw $this->createNotFoundException("No zooArcadia found for ID {$id}");
        }

        return $this->json(
            ['message' => "A zooArcadia was found: {$zooArcadia->getNom()} for ID {$zooArcadia->getId()}"]
        );
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $zooArcadia = $this->repository->findOneBy(['id' => $id]);
        if (!$zooArcadia) {
            throw $this->createNotFoundException("No zooArcadia found for ID {$id}");
        }
        
        $zooArcadia->setNom($request->request->get('nom', 'ZooArcadia name updated'));
        $this->manager->flush();

        return $this->json(
            ['message' => "ZooArcadia resource updated with ID {$zooArcadia->getId()}"]
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $zooArcadia = $this->repository->findOneBy(['id' => $id]);
        if (!$zooArcadia) {
            throw $this->createNotFoundException("No ZooArcadia found for ID {$id}");
        }

        $this->manager->remove($zooArcadia);
        $this->manager->flush();

        return $this->json(['message' => "ZooArcadia resource deleted"], Response::HTTP_NO_CONTENT);
    }
}