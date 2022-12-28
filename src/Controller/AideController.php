<?php

namespace App\Controller;

use App\Entity\Aide;
use App\Entity\Member;
use App\Form\AideType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AideController extends AbstractController
{

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    #[Route('/aide', name: 'app_aide')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Aide::class);
        $aides = $repo->findAll();
        return $this->render('aide/index.html.twig', [
            'controller_name' => 'AideController',
            'aides' => $aides
        ]);
    }



    #[Route('/add-aide', name: 'app_add_aide')]
    public function create(Request $req): Response
    {
        $aide = new Aide();
        $manager = $this->doctrine->getManager();
        $form = $this->createForm(AideType::class, $aide);

        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($form->getData());
            $manager->flush();

            dd("done");
        }

        return $this->renderForm('aide/create.html.twig',[
            'form' => $form
        ]);



    }
}
