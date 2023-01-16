<?php

namespace App\Controller;

use App\Repository\EmpruntRepository;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    public function __construct(
        private MemberRepository $memberRepo,
        private EmpruntRepository $empruntRepo,
    )
    {
        
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('espace-comptable/dashboard/dashboard.html.twig',
    [
        "members"=>$this->memberRepo->findAll(),
        "emprunts"=>$this->empruntRepo->findAll(),
    ]);
    }

    #[Route("/dashboard/page-blank", name:"blank_page")]
    public function pageBlank():Response{
        return $this->render("espace-comptable/blank.html.twig");
    }

    #[Route("/dashboard/tontine", name:"dashboard_tontine")]
    public function totine():Response{
        return $this->render("espace-comptable/tontine.html.twig");
    }
    

    #[Route("/dashoard/emprunt", name:"app_dashboard_emprunts")]
    public function emprunt():Response{

        return $this->render("espace-comptable/emprunts.html.twig");
    }

    
}
