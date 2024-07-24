<?php

namespace App\Controller;

use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/consultations')]
class ConsultationController extends AbstractController
{
    #[Route('/filter-by-date', name: 'consultation_filter_by_date', methods:['GET'])]
    public function filterByDate(Request $request, ConsultationRepository $consultationRepository): Response
    {
        $startDate = $request->query->get('start_date');
        $endDate = $request->query->get('end_date');

        if ($startDate && $endDate) {
            $startDate = new \DateTime($startDate);
            $endDate = new \DateTime($endDate);
            $consultations = $consultationRepository->filtreParDate($startDate, $endDate);
        } else {
            $consultations = [];
        }

        return $this->render('consultation/filter_by_date.html.twig', [
            'consultations' => $consultations,
        ]);
    }
}