<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
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
        return $this->render('default/services.html.twig');
    }

    #[Route('/nos-projets', name: 'app_projet')]
    public function projet(): Response
    {
        return $this->render('default/projets.html.twig');
    }

    #[Route('/nos-projets-1', name: 'app_projet_detail')]
    public function projetDetail(): Response
    {
        return $this->render('default/projet-single.html.twig');
    }
}
