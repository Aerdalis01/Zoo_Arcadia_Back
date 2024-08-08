<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Services;
use App\Entity\Animaux;
use App\Entity\Habitats;
use App\Entity\Horaires;
use App\Form\UserType;
use App\Form\AnimauxType;
use App\Form\HabitatsType;
use App\Form\HorairesType;
use App\Service\AdminService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin', name: 'app_api_admin_')]
class AdminController extends AbstractController
{
    private $adminService;
    private $entityManager;

    public function __construct(AdminService $adminService, EntityManagerInterface $entityManager)
    {
        $this->adminService = $adminService;
        $this->entityManager = $entityManager;
    }

    // User CRUD
    #[Route('/user/create', name: 'user_create', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->adminService->createUser($data['password'], $data['email'], $data['role']);

            return $this->json(['message' => 'User created successfully'], Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/user/edit/{id}', name: 'user_edit', methods: ['PUT'])]
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->adminService->updateUser($user, $data['password'], $data['email']);

            return $this->json(['message' => 'User updated successfully'], Response::HTTP_OK);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/user/delete/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUser(User $user): Response
    {
        $this->adminService->deleteUser($user);

        return $this->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }

    // Services CRUD
    #[Route('/services', name: 'services_list', methods: ['GET'])]
    public function listServices(): Response
    {
        $services = $this->entityManager->getRepository(Services::class)->findAll();

        return $this->json($services);
    }

    #[Route('/services/delete/{id}', name: 'services_delete', methods: ['DELETE'])]
    public function deleteService(Services $service): Response
    {
        $this->entityManager->remove($service);
        $this->entityManager->flush();

        return $this->json(['message' => 'Service deleted successfully'], Response::HTTP_OK);
    }

    // Animaux CRUD
    #[Route('/animaux', name: 'animaux_list', methods: ['GET'])]
    public function listAnimaux(): Response
    {
        $animaux = $this->entityManager->getRepository(Animaux::class)->findAll();

        return $this->json($animaux);
    }

    #[Route('/animaux/create', name: 'animaux_create', methods: ['POST'])]
    public function createAnimaux(Request $request): Response
    {
        $animaux = new Animaux();
        $form = $this->createForm(AnimauxType::class, $animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($animaux);
            $this->entityManager->flush();

            return $this->json(['message' => 'Animaux created successfully'], Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/animaux/edit/{id}', name: 'animaux_edit', methods: ['PUT'])]
    public function editAnimaux(Request $request, Animaux $animaux): Response
    {
        $form = $this->createForm(AnimauxType::class, $animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->json(['message' => 'Animaux updated successfully'], Response::HTTP_OK);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/animaux/delete/{id}', name: 'animaux_delete', methods: ['DELETE'])]
    public function deleteAnimaux(Animaux $animaux): Response
    {
        $this->entityManager->remove($animaux);
        $this->entityManager->flush();

        return $this->json(['message' => 'Animaux deleted successfully'], Response::HTTP_OK);
    }

    // Habitats CRUD
    #[Route('/habitats', name: 'habitats_list', methods: ['GET'])]
    public function listHabitats(): Response
    {
        $habitats = $this->entityManager->getRepository(Habitats::class)->findAll();

        return $this->json($habitats);
    }

    #[Route('/habitats/create', name: 'habitats_create', methods: ['POST'])]
    public function createHabitats(Request $request): Response
    {
        $habitat = new Habitats();
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($habitat);
            $this->entityManager->flush();

            return $this->json(['message' => 'Habitats created successfully'], Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/habitats/edit/{id}', name: 'habitats_edit', methods: ['PUT'])]
    public function editHabitats(Request $request, Habitats $habitat): Response
    {
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->json(['message' => 'Habitats updated successfully'], Response::HTTP_OK);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/habitats/delete/{id}', name: 'habitats_delete', methods: ['DELETE'])]
    public function deleteHabitats(Habitats $habitat): Response
    {
        $this->entityManager->remove($habitat);
        $this->entityManager->flush();

        return $this->json(['message' => 'Habitats deleted successfully'], Response::HTTP_OK);
    }
    
}
