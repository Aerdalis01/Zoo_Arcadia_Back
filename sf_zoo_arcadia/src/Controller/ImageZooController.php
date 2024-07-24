<?php

namespace App\Controller;

use App\Entity\ImageZoo;
use App\Repository\ImageZooRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/api/imagezoo', name: 'app_api_imagezoo_')]
class ImageZooController extends AbstractController
{
    private $repository;
    private $manager;

    public function __construct(ImageZooRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $images = $this->repository->findAll();

        return $this->json($images);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $image = $this->repository->find($id);

        if (!$image) {
            throw $this->createNotFoundException("Aucune image trouvée pour l'id {$id}");
        }

        return $this->json($image);
    }

    #[Route('/upload', name: 'upload', methods: ['POST'])]
    public function upload(Request $request, SluggerInterface $slugger): Response
    {
        $nom = $request->request->get('nom');
        $subDirectory = $request->request->get('subDirectory');
        $imageFile = $request->files->get('image');

        if (!$nom || !$subDirectory || !$imageFile) {
            return $this->json(['message' => 'Nom, sous-dossier et image sont requis'], Response::HTTP_BAD_REQUEST);
        }

        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        $uploadDir = $this->getParameter('images_directory').'/'.$subDirectory;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        try {
            $imageFile->move(
                $uploadDir,
                $newFilename
            );
        } catch (FileException $e) {
            return $this->json(['message' => 'Échec du téléchargement'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $image = new ImageZoo();
        $image->setNom($nom);
        $image->setImageSubDirectory($subDirectory);
        $image->setImagePath($subDirectory.'/'.$newFilename);

        $this->manager->persist($image);
        $this->manager->flush();

        return $this->json(
            ['message' => 'Image téléchargée avec succès', 'id' => $image->getId()],
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): Response
    {
        $image = $this->repository->find($id);

        if (!$image) {
            return $this->json(['message' => "Aucune image trouvée pour l'id {$id}"], Response::HTTP_NOT_FOUND);
        }

        $nom = $request->request->get('nom');
        $subDirectory = $request->request->get('subDirectory');

        if ($nom) {
            $image->setNom($nom);
        }

        if ($subDirectory) {
            $image->setImageSubDirectory($subDirectory);
        }

        $this->manager->persist($image);
        $this->manager->flush();

        return $this->json(['message' => 'Image mise à jour avec succès']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $image = $this->repository->find($id);

        if (!$image) {
            return $this->json(['message' => "Aucune image trouvée pour l'id {$id}"], Response::HTTP_NOT_FOUND);
        }

        // Optionally, delete the image file from the server
        $imagePath = $this->getParameter('images_directory').'/'.$image->getImagePath();
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $this->manager->remove($image);
        $this->manager->flush();

        return $this->json(['message' => 'Image supprimée avec succès'], Response::HTTP_NO_CONTENT);
    }
}