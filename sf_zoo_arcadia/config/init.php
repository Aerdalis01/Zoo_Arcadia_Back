<?php

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';


$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env', __DIR__.'/../.env.local');


$kernel = new App\Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();

/** @var EntityManagerInterface $entityManager */
$entityManager = $container->get(EntityManagerInterface::class);
/** @var UserPasswordHasherInterface $passwordHasher */
$passwordHasher = $container->get(UserPasswordHasherInterface::class);

$adminEmail = $_ENV['ADMIN_EMAIL'];
$adminPassword = $_ENV['ADMIN_PASSWORD'];

/** @var Admin $existingAdmin */
$existingAdmin = $entityManager->getRepository(Admin::class)->findOneBy([]);

if (!$existingAdmin) {
    $admin = new Admin();
    $admin->setEmail($adminEmail);
    $admin->setPassword($passwordHasher->hashPassword($admin, $adminPassword));
    $admin->setCreatedAt(new \DateTimeImmutable());

    $entityManager->persist($admin);
    $entityManager->flush();

    echo "Admin user created successfully.\n";
} else {
    echo "Admin user already exists.\n";
}
