<?php

namespace App\Controller;

use App\Entity\Avis;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('api/avis', name: '_app_api_avis_')]
class AvisController extends AbstractController
{
    private Serializer $serializer;


    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            ])];
        $this->serializer = new Serializer($normalizers, $encoders,);
    }


    #[Route('/', name: 'show', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $avis = $entityManager->getRepository(Avis::class)->findAll();
        $json = $this->serializer->serialize($avis, 'json',['groups' => 'avis_basic']);
        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }

    #[Route('/new', name: 'avis', methods: ['POST'])]
    public function createAvis(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON data'], Response::HTTP_BAD_REQUEST);
        }
        
        $avis = new Avis();
        $avis->setPseudo($data['pseudo']);
        $avis->setCommentaireAvis($data['commentaireAvis']);
        $avis->setNote($data['note']);
        $avis->setCreatedAt(new \DateTimeImmutable());

        if (empty($avis->getPseudo()) || empty($avis->getCommentaireAvis()) || empty($avis->getNote())) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($avis);
        $entityManager->flush();

        return $this->json([
            'message' => 'Votre avis a été soumis avec succès',
        ], Response::HTTP_CREATED);
    }
}
