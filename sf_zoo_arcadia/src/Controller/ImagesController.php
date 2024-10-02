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

    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
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
        dd($image);
        return $this->json($image, Response::HTTP_OK);
    }

    #[Route('/new', name: 'add_image_json', methods: ['POST'])]
    public function addImageJson(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): JsonResponse
    {
        $image = new Images();

        // Récupérer les données du formulaire (JSON + Fichier)
        $nom = $request->request->get('nom');
        $imageSubDirectory = $request->request->get('image_sub_directory');
        $file = $request->files->get('file');

        if (!$nom || !$imageSubDirectory || !$file) {
            return new JsonResponse(['error' => 'Tous les champs sont requis.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Traitement du fichier
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

            // Créer le chemin complet avec images_directory et image_sub_directory
            $uploadDirectory = $this->getParameter('images_directory') . '/' . $imageSubDirectory;

            // Créez le sous-dossier s'il n'existe pas
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            try {
                // Déplacer le fichier vers le bon répertoire
                $file->move($uploadDirectory, $newFilename);
            } catch (FileException $e) {
                return new JsonResponse(['error' => 'Erreur lors du téléchargement du fichier.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Stocker le chemin du fichier dans l'entité Image
            $image = new Images();
            $image->setNom($nom);
            $image->setImagePath('/uploads/images/' . $imageSubDirectory . '/' . $newFilename);
            $image->setImageSubDirectory($imageSubDirectory);

            $entityManager->persist($image);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Image ajoutée avec succès !'], JsonResponse::HTTP_CREATED);
        }

        return new JsonResponse(['error' => 'Aucun fichier détecté.'], JsonResponse::HTTP_BAD_REQUEST);
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

        // Suppression du fichier du système de fichiers
        $imagePath = $this->getParameter('upload_directory') . '/' . $image->getImagePath();
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Suppression de l'entité de la base de données
        $this->entityManager->remove($image);
        $this->entityManager->flush();

        return $this->json(['message' => 'Image supprimée avec succès'], Response::HTTP_OK);
    }   
}
