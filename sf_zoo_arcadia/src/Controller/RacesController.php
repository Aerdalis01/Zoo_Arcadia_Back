<?php

namespace App\Controller;

use App\Entity\Races;
use App\Form\RacesType;
use App\Repository\RacesRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin/races', name: '_app_api_admin_races_')]
class RacesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Serializer $serializer;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders,);
    }


    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SerializerInterface $serializer): JsonResponse
    {
        $races = $this->entityManager->getRepository(Races::class)->findAll();

        $data = $serializer->serialize($races, 'json', ['groups' => ['races_basic', 'races_animaux']]);
    
        return new JsonResponse($data, 200, [], true);
    }
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function showRace(int $id, RacesRepository $racesRepository, SerializerInterface $serializer): JsonResponse
    {
        $race = $racesRepository->find($id);

        if (!$race) {
            return $this->json(['error' => 'Race not found'], Response::HTTP_NOT_FOUND);
        }
    
        $data = $serializer->serialize($race, 'json', ['groups' => ['races_basic', 'races_animaux']]);

        return new JsonResponse($data, 200, [], true);  // true pour indiquer que $data est déjà en JSON
    }


    #[Route('/new', name: 'races', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent(); 
    
        try {
            $race = $serializer->deserialize($data, Races::class, 'json', ['groups' => ['races_basic', 'races_animaux']]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Désérialisation échouée', 'details' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($race);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Race ajoutée avec succès'], JsonResponse::HTTP_CREATED);
    }


    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request, RacesRepository $racesRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $race = $racesRepository->find($id);

        if (!$race) {
            return new JsonResponse(['error' => 'Race not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
    
        try {
            $serializer->deserialize($data, Races::class, 'json', [
                'object_to_populate' => $race,  
                'groups' => ['races_basic', 'races_animaux']
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Désérialisation échouée', 'details' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Race mise à jour avec succès'], JsonResponse::HTTP_OK);
    }


    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, RacesRepository $racesRepository): Response
    {
        $race = $racesRepository->find($id);
        
        if (!$race) {
            return $this->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($race);
        $this->entityManager->flush();

        return $this->json(['message' => 'Race supprimée avec succès'], Response::HTTP_OK);
    }
}
