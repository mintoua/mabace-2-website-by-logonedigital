<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\CategoryPostRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,

    )
    {}

    #[Route('/nos-projets', name: 'app_projet')]
    public function index(Request $request): Response
    {
        $_projects = $this->entityManager->getRepository (Projet::class)->findAll ();
        $projects = $this->paginator->paginate(
            $_projects,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('projet/projets.html.twig', [
            'projets' => $projects,
        ]);
    }

    #[Route('/nos-projets/{slug}', name: 'app_projet_detail')]
    public function projetDetail(Projet $projet): Response
    {
        return $this->render('projet/projet-single.html.twig',[
            'projet'=>$projet,
        ]);
    }
}
