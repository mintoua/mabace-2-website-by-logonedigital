<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Sanction;
use App\Form\SanctionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Flasher\Prime\FlasherInterface;
use Symfony\Component\HttpFoundation\Request;

class SanctionController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {}

    #[Route('/dashboard/sanction', name: 'app_dashboard_sanctions')]
    public function index(): Response
    {
        return $this->render('espace-comptable/sanction/index.html.twig', [
            'sanctions' => $this->doctrine->getRepository(Sanction::class)->findAll(),
        ]);
    }

    #[Route('/dashboard/sanction/ajouter/{matricule}', name: 'app_dashboard_add_sanction')]
    public function addSanction(Request $request, Member $member){

        $sanction = new Sanction();
        $form = $this->createForm(SanctionType::class, $sanction);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $sanction->setMembre($member);

            $this->em->persist($sanction);
            $this->em->flush();

            return $this->redirectToRoute('app_dashboard_sanctions');
        }

        return $this->render("espace-comptable/sanction/sanction_new.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route('/dashboard/sanction/modifier/{id}', name: 'app_dashboard_edit_sanction')]
    public function editSanction(Request $request, Sanction $sanction){

        $form = $this->createForm(SanctionType::class, $sanction);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();

            return $this->redirectToRoute('app_dashboard_sanctions');
        }

        return $this->render("espace-comptable/sanction/sanction_new.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route('/dashboard/sanction/supprimer/{id}', name: 'app_delete_sanction')]
    public function deleteSanction(Sanction $sanction){

        $this->em->remove($sanction);
        $this->em->flush();
        $this->flasher->addSuccess("Suppression réussie");
        return $this->redirectToRoute("app_dashboard_sanctions");
    }
}
