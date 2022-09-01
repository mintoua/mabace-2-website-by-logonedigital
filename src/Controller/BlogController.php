<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('blog/blog.html.twig');
    }
    #[Route('/blog-1', name: 'app_blog_detail')]
    public function blogDetail(): Response
    {
        return $this->render('blog/blog-single.html.twig');
    }
}
