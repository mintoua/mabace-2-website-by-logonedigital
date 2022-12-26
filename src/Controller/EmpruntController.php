<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Member;
use App\Form\EmpruntType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Flasher\Prime\FlasherInterface;
use Symfony\Component\HttpFoundation\Request;

class EmpruntController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {}

    #[Route('/dashboard/emprunt', name: 'app_dashboard_emprunts')]
    public function index(): Response
    {
        return $this->render("espace-comptable/emprunts.html.twig",[
            "emprunts"=>$this->doctrine->getRepository(Emprunt::class)->findAll()
        ]);
    }

    #[Route('/dashboard/emprunt/{matricule}', name: 'app_dashboard_add_emprunt')]
    public function addEmprunt(Request $request, Member $member)
    {
        //dd($member);
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $emprunt->setMembre($member);
            $emprunt->setCreatedAt(new \DateTime('now'));
            $emprunt->setEtat(0);

            $this->em->persist($emprunt);
            $this->em->flush();

            $this->flasher->addSuccess("Emprunt Attribué avec succés");
            return $this->redirectToRoute('app_dashboard_emprunts');
        }
        return $this->render("espace-comptable/emprunt/emprunt_new.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashboard/emprunt/supprime/{id}", name:"app_dashboard_emprunt_delete")]
    public function deleteMember(Emprunt $emprunt):Response{
        $this->em->remove($emprunt);
        $this->em->flush();
        $this->flasher->addSuccess("Emprunt supprimé");
        return $this->redirectToRoute("app_dashboard_emprunts");
    }
}
