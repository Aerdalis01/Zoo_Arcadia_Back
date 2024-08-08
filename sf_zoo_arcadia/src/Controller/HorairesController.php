<?php

namespace App\Controller\Admin;

use App\Entity\Horaires;
use App\Form\HorairesType;
use App\Service\HorairesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/admin/horaires', name: ('_app_api_admin_horaires_'))]
class HorairesController extends AbstractController
{
    private $horairesService;

    public function __construct(HorairesService $horairesService)
    {
        $this->horairesService = $horairesService;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $horaires = $this->horairesService->findAll();
        return $this->render('admin/horaires/index.html.twig', [
            'horaires' => $horaires,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $horaire = new Horaires();
        $form = $this->createForm(HorairesType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $horaire->setCreatedAt(new \DateTimeImmutable());
            $this->horairesService->save($horaire);

            return $this->redirectToRoute('admin_horaires_index');
        }

        return $this->render('admin/horaires/new.html.twig', [
            'horaire' => $horaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_horaires_show', methods: ['GET'])]
    public function show(Horaires $horaire): Response
    {
        return $this->render('admin/horaires/show.html.twig', [
            'horaire' => $horaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_horaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Horaires $horaire): Response
    {
        $form = $this->createForm(HorairesType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $horaire->setUpdatedAt(new \DateTimeImmutable());
            $this->horairesService->update($horaire);

            return $this->redirectToRoute('admin_horaires_index');
        }

        return $this->render('admin/horaires/edit.html.twig', [
            'horaire' => $horaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_horaires_delete', methods: ['POST'])]
    public function delete(Request $request, Horaires $horaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$horaire->getId(), $request->request->get('_token'))) {
            $this->horairesService->delete($horaire);
        }

        return $this->redirectToRoute('admin_horaires_index');
    }
}
