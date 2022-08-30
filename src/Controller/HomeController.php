<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('frontoffice/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/nos-projets', name: 'app_projects')]
    public function projects()
    {
        $projects = $this->entityManager->getRepository (Projet::class)->findAll ();
        return $this->render ('frontoffice/projets.html.twig',[
            'projets' => $projects
        ]);
    }

    #[Route('/les-services', name: 'app_services')]
    public function services()
    {
        $services = $this->entityManager->getRepository (Service::class)->findAll ();
        $categoriesServices = $this->entityManager->getRepository (ServiceCategory::class)->findAll ();

        return $this->render ('frontoffice/services.html.twig',[
            'services'=>$services,
            'categoriesServices'=>$categoriesServices
        ]);
    }
}
