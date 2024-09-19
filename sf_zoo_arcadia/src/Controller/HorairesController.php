<?php

namespace App\Controller;

use App\Entity\Horaires;
use App\Form\HorairesType;
use App\Repository\HorairesRepository;
use App\Service\HorairesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[Route('/api/admin/horaires', name: 'app_api_admin_horaires_')]
class HorairesController extends AbstractController
{
    private HorairesService $horairesService;
    private Serializer $serializer;

    public function __construct(HorairesService $horairesService)
    {
        $this->horairesService = $horairesService;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders,);
        
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $horaires = $entityManager->getRepository(Horaires::class)->findAll();
        $json = $this->serializer->serialize($horaires, 'json');
        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $horaires = $entityManager->getRepository(Horaires::class)->findAll();
        $json = $this->serializer->serialize($horaires, 'json');
        dd($json);
        return $this->json($horaires, Response::HTTP_OK);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(HorairesType::class);
        $form->handleRequest($request);

        $data = json_decode($request->getContent(),true); 
        $jour = $data['jour'] ?? null;
        $heureOuvertureZoo = isset($data['Heure d\'ouverture']) ? new \DateTimeImmutable($data['Heure d\'ouverture']) : null;
        $heureFermetureZoo = isset($data['Heure de fermeture']) ? new \DateTimeImmutable($data['Heure de fermeture']) : null;
        $horairesService = $data['Horaire du service'] ?? [];
        $titreHoraire = $data['Titre de l\'horaire'] ?? null;
        
        try 
        {
            $horaires = $this->horairesService->createHoraire(
                $jour,
                $heureOuvertureZoo,
                $heureFermetureZoo,
                $horairesService,
                $titreHoraire
            );
            return $this->json(['message' => 'Horaire created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['PUT'])]
    public function edit(Request $request, int $id, HorairesRepository $horairesRepository): Response
    {
        $horaires = $horairesRepository->find($id);
        if (!$horaires) {
            return $this->json(['error' => 'horaires not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(),true); 
        $jour = $data['jour'];
        $heureOuvertureZoo = $data['Heure d\'ouverture'];
        $heureFermetureZoo = $data['Heure de fermeture'];
        $horairesService = $data['Horaires du service'];
        $titreHoraire = $data['Titre de l\'horaire'];

        try {
            // Utiliser le service pour mettre à jour l'animal
            $this->horairesService->updateHoraire($horaires, $jour, $heureOuvertureZoo, $heureFermetureZoo, $horairesService, $titreHoraire);

            return $this->json(['message' => 'Horaire updated successfully', 'horaire' => $horaires], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while updating the horaire'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, HorairesRepository $horairesRepository): Response
    {
        $horaire = $horairesRepository->find($id);
        
        if (!$horaire) {
            return $this->json(['error' => 'Horaire not found'], Response::HTTP_NOT_FOUND);
        }

        $this->horairesService->deleteHoraire($horaire);
        return $this->json(['message' => 'Horaire supprimé avec succès'], Response::HTTP_OK);
    }
}
