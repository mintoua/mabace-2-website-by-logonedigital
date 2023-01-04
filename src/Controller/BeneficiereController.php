<?php

namespace App\Controller;

use App\Repository\BeneficiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeneficiereController extends AbstractController
{

    public function __construct(
        private BeneficiereRepository $benefRepo
    ){

    }

    #[Route('/dashboard/beneficiere', name: 'app_dashboard_beneficiere')]
    public function index(): Response
    {

        return $this->render('espace-comptable/beneficiere/beneficiere.html.twig', [
            'benefs' => $this->benefRepo->findAll(),
        ]);
    }
}
