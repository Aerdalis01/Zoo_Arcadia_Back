<?php

namespace App\Service;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminInitializer
{
    private $entityManager;
    private $passwordHasher;
    private $adminEmail;
    private $adminPassword;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        string $adminEmail,
        string $adminPassword
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->adminEmail = $adminEmail;
        $this->adminPassword = $adminPassword;
    }

    public function initializeAdmin(): void
    {
        $existingAdmin = $this->entityManager->getRepository(Admin::class)->findOneBy([]);

        if (!$existingAdmin) {
            $admin = new Admin();
            $admin->setEmail($this->adminEmail);
            $admin->setUsername($this->adminEmail);
            $admin->setPassword($this->passwordHasher->hashPassword($admin, $this->adminPassword));
            $admin->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($admin);
            $this->entityManager->flush();

            echo "Admin user created successfully.\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}