<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Employe;
use App\Entity\Veterinaire;
use App\Form\UserType;
use App\Service\UserService;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin/user', name: 'app_api_admin_user_')]
class UserController extends AbstractController
{
    private UserService $userService;
    private MailerService $mailerService;

    public function __construct(UserService $userService, MailerService $mailerService)
    {
        $this->userService = $userService;
        $this->mailerService = $mailerService;
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');  

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $role = $data['role'];

            if ($role === 'employe') {
                $user = new Employe();
            } elseif ($role === 'veterinaire') {
                $user = new Veterinaire();
            } else {
                return $this->json(['error' => 'Invalid role specified'], Response::HTTP_BAD_REQUEST);
            }

            $user->setEmail($data['email']);
            $user->setUsername($data['email']);
            $user->setPassword($data['password']);  

            $this->userService->createUser($user);


            $this->mailerService->sendAccountCreationEmail($user->getEmail(), $user->getUsername());

            return $this->json(['message' => 'User created successfully'], Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    // Edit an existing user
    #[Route('/edit/{id}', name: 'edit', methods: ['PUT'])]
    public function editUser(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');  // Only admin can edit users

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user->setEmail($data['email']);
            $user->setUsername($data['email']);
            if ($data['password']) {
                $user->setPassword($data['password']);  // Password will be hashed in the service
            }

            $this->userService->updateUser($user);

            return $this->json(['message' => 'User updated successfully'], Response::HTTP_OK);
        }

        return $this->json(['errors' => (string) $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
    }

    // Delete a user
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteUser(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');  // Only admin can delete users

        $this->userService->deleteUser($user);

        return $this->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
