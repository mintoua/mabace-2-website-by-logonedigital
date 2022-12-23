<?php

namespace App\Controller;

use App\Entity\Emprunt;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class EmpruntController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
    )
    {}

    #[Route('/dashoard/emprunt', name: 'app_dashboard_emprunts')]
    public function index(): Response
    {
        return $this->render("espace-comptable/emprunts.html.twig",[
            "emprunts"=>$this->doctrine->getRepository(Emprunt::class)->findAll()
        ]);
    }
}
