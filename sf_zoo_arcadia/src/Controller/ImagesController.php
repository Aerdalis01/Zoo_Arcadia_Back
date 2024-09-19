<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/admin/images', name: '_api_app_admin_images_')]
class ImagesController extends AbstractController
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
    public function index(): Response
    {
        $images = $this->entityManager->getRepository(Images::class)->findAll();

        return $this->json($images);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, ImagesRepository $imagesRepository): Response
    {
        $image = $imagesRepository->find($id);

        if (!$image) {
            return $this->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($image, Response::HTTP_OK);
    }

    #[Route('/new', name: 'add_image_json', methods: ['POST'])]
    public function addImageJson(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent();
        try {
            $image = $serializer->deserialize($data, Images::class, 'json', ['groups' => 'images_basic']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Désérialisation échouée', 'details' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($image);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Image ajoutée avec succès'], JsonResponse::HTTP_CREATED);
    }



    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
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

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, ImagesRepository $imagesRepository): Response
    {
        $image = $imagesRepository->find($id);
        
        if (!$image) {
            return $this->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($image);
        $this->entityManager->flush();

        return $this->json(['message' => 'Image supprimée avec succès'], Response::HTTP_OK);
    }
}
