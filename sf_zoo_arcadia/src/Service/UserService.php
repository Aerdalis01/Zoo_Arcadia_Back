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
        if (!$user->getPassword()) {
            throw new \InvalidArgumentException('Password cannot be empty');
        }

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(new \DateTimeImmutable());

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create user: ' . $e->getMessage());
        }
    }

    
    public function updateUser(User $user): void
    {
        $user->setUpdatedAt(new \DateTimeImmutable());

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to update user: ' . $e->getMessage());
        }
    }

    
    public function deleteUser(User $user): void
    {
        try {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to delete user: ' . $e->getMessage());
        }
    }
}
