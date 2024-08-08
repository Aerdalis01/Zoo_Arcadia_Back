<?php

namespace App\Service;

use App\Entity\Employe;
use App\Entity\Veterinaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminService
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(string $password, string $email, string $role): object
    {
        switch ($role) {
            case 'employe':
                $user = new Employe();
                break;
            case 'veterinaire':
                $user = new Veterinaire();
                break;
            default:
                throw new \InvalidArgumentException('Invalid role');
        }

        $user->setUsername($email);  // Username is the email
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function updateUser(object $user, ?string $password, ?string $email): object
    {
        if ($email) {
            $user->setUsername($email);
            $user->setEmail($email);
        }

        if ($password) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        }

        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $user;
    }

    public function deleteUser(object $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
