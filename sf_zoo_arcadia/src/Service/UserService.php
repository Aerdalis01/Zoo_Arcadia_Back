<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Employe;
use App\Entity\Admin;
use App\Entity\Veterinaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(string $username, string $password, string $email, string $role)
    {
        $userClass = $this->getUserClass($role);
        if (!$userClass) {
            throw new \InvalidArgumentException('Invalid role specified.');
        }

        /** @var User $user */
        $user = new $userClass();
        $user->setUsername($username);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function updateUser(User $user, array $newData)
    {
        if (isset($newData['username']) && $user->getUsername() !== $newData['username']) {
            $user->setUsername($newData['username']);
        }

        if (isset($newData['password'])) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $newData['password']));
        }

        if (isset($newData['email']) && $user->getEmail() !== $newData['email']) {
            $user->setEmail($newData['email']);
        }

        if (isset($newData['updatedAt'])) {
            $user->setUpdatedAt(new \DateTimeImmutable());
        }

        $this->entityManager->flush();
    }

    public function deleteUser(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    private function getUserClass(string $role): ?string
    {
        switch ($role) {
            case 'employe':
                return Employe::class;
            case 'admin':
                return Admin::class;
            case 'veterinaire':
                return Veterinaire::class;
            default:
                return null;
        }
    }
}
