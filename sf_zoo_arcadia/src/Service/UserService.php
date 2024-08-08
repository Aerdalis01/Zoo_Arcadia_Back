<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserService
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(User $user): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function updateUser(User $user): void
    {
        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();
    }
}
