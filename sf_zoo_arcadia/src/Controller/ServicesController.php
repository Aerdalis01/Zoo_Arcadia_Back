<?php

namespace App\Controller\Admin;

use App\Entity\Services;
use App\Entity\Images;
use App\Form\ServicesType;
use App\Service\ServicesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/api/admin/services', name: ('_app_api_admin_services_'))]
class ServicesController extends AbstractController
{
    private $servicesService;
    private $slugger;

    public function __construct(ServicesService $servicesService, SluggerInterface $slugger)
    {
        $this->servicesService = $servicesService;
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $services = $this->servicesService->findAll();
        return $this->render('admin/services/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $service = new Services();
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setCreatedAt(new \DateTimeImmutable());

            // Ajout des images depuis le formulaire
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                $image->setServices($service);
                $service->addImage($image);
            }

            $this->servicesService->save($service);

            return $this->redirectToRoute('admin_services_index');
        }

        return $this->render('admin/services/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Services $service): Response
    {
        return $this->render('admin/services/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Services $service): Response
    {
        $form = $this->createForm(ServicesType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setUpdatedAt(new \DateTimeImmutable());

            // Ajout des images depuis le formulaire
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                $image->setServices($service);
                $service->addImage($image);
            }

            $this->servicesService->update($service);

            return $this->redirectToRoute('admin_services_index');
        }

        return $this->render('admin/services/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Services $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $this->servicesService->delete($service);
        }

        return $this->redirectToRoute('admin_services_index');
    }
}
