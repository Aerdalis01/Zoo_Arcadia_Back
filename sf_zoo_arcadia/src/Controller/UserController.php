<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Veterinaire;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/create-user', name: 'app_user_create')]
    public function createUser(Request $request, UserService $userService): Response
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
                throw new \InvalidArgumentException('Invalid role specified.');
            }

            $user->setEmail($data['email']);
            $user->setUsername($data['email']);
            $user->setPassword($data['password']);


            $userService->createUser($user);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('admin/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
