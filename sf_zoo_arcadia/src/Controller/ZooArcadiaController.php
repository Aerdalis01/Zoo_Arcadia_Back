<?php

namespace App\Controller;

use App\Entity\ZooArcadia;
use App\Entity\Habitats;
use App\Form\ZooArcadiaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/zoo', name: 'app_api_zooArcadia_')]
class ZooArcadiaController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $zoos = $this->entityManager->getRepository(ZooArcadia::class)->findAll();

        return $this->json($zoos);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $zoo = new ZooArcadia();
        $form = $this->createForm(ZooArcadiaType::class, $zoo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($zoo);
            $this->entityManager->flush();

            return $this->redirectToRoute('zoo_index');
        }

        return $this->render('/new.html.twig', [
            'zoo' => $zoo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(ZooArcadia $zoo): Response
    {
        return $this->render('zoo/show.html.twig', [
            'zoo' => $zoo,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ZooArcadia $zoo): Response
    {
        $form = $this->createForm(ZooArcadiaType::class, $zoo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('zoo_index');
        }

        return $this->render('zoo/edit.html.twig', [
            'zoo' => $zoo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, ZooArcadia $zoo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zoo->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($zoo);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('zoo_index');
    }

    #[Route('/{id}/add-habitat', name: 'add_habitat', methods: ['POST'])]
    public function addHabitat(Request $request, ZooArcadia $zoo): Response
    {
        $data = json_decode($request->getContent(), true);
        $habitat = new Habitats();
        $habitat->setNom($data['nom']);
        $zoo->addHabitat($habitat);

        $this->entityManager->persist($habitat);
        $this->entityManager->flush();

        return $this->json(['status' => 'Habitat added']);
    }

    #[Route('/{zooId}/remove-habitat/{habitatId}', name: 'zoo_remove_habitat', methods: ['DELETE'])]
    public function removeHabitat(int $zooId, int $habitatId): Response
    {
        $zoo = $this->entityManager->getRepository(ZooArcadia::class)->find($zooId);
        $habitat = $this->entityManager->getRepository(Habitats::class)->find($habitatId);

        if ($zoo && $habitat && $habitat->getZooArcadia() === $zoo) {
            $zoo->removeHabitat($habitat);
            $this->entityManager->flush();

            return $this->json(['status' => 'Habitat removed']);
        }

        return $this->json(['status' => 'Habitat not found'], Response::HTTP_NOT_FOUND);
    }
}
