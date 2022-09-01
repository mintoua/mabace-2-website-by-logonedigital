<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\ServiceCategory;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/petites-annonces', name: 'app_services')]
    public function index(): Response
    {
        $services = $this->entityManager->getRepository (Service::class)->findAll ();
        $categoriesServices = $this->entityManager->getRepository (ServiceCategory::class)->findAll ();

        return $this->render('annonce/services.html.twig',[
            'services'=>$services,
            'categoriesServices'=>$categoriesServices
        ]);
    }
}
