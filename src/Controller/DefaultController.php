<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    public function __construct (
        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('default/about-us.html.twig');
    }

    #[Route('/blog', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('default/blog.html.twig');
    }
    #[Route('/blog-1', name: 'app_blog_detail')]
    public function blogDetail(): Response
    {
        return $this->render('default/blog-single.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig');
    }

    #[Route('/petites-annonces', name: 'app_services')]
    public function services(): Response
    {
        $services = $this->entityManager->getRepository (Service::class)->findAll ();
        $categoriesServices = $this->entityManager->getRepository (ServiceCategory::class)->findAll ();

        return $this->render('default/services.html.twig',[
            'services'=>$services,
            'categoriesServices'=>$categoriesServices
        ]);
    }

    #[Route('/nos-projets', name: 'app_projet')]
    public function projet(): Response
    {
        $projects = $this->entityManager->getRepository (Projet::class)->findAll ();
        return $this->render('default/projets.html.twig',[
            'projets' => $projects
        ]);
    }

    #[Route('/nos-projets-1', name: 'app_projet_detail')]
    public function projetDetail(): Response
    {
        return $this->render('default/projet-single.html.twig');
    }
}
