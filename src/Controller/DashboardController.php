<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('espace-comptable/index.html.twig');
    }

    #[Route("/dashoard/page-blank", name:"blank_page")]
    public function pageBlank():Response{
        return $this->render("espace-comptable/blank.html.twig");
    }

    #[Route("/dashoard/tontine", name:"dashboard_tontine")]
    public function totine():Response{
        return $this->render("espace-comptable/tontine.html.twig");
    }

    #[Route("/dashoard/emprunt", name:"app_dashboard_emprunts")]
    public function emprunt():Response{
        
        return $this->render("espace-comptable/emprunts.html.twig");
    }

    
}
