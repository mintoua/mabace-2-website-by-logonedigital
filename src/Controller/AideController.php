<?php

namespace App\Controller;

use App\Entity\Aide;
use App\Entity\Member;
use App\Form\AideType;
use App\Repository\AideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AideController extends AbstractController
{
    public function __construct(
        private AideRepository $aideRepository,
        private EntityManagerInterface $em,
         private FlasherInterface $flasher,
    )
    {
        
    }

    #[Route('/dashboard/aide/list', name: 'app_dashboard_aide_list')]
    public function listAllAide(): Response
    {
        return $this->render('espace-comptable/aide/list_aide.html.twig', [
            'aides' => $this->aideRepository->findAll(),
        ]);
    }

    #[Route("/dashboard/aide/new/{matricule}", name:"app_dashboard_aide_new_from_member_profil")]
    public function newAide(Request $request, Member $member):Response{
        $aide = new Aide();
        $form = $this->createForm(AideType::class, $aide);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $aide->addMembre($member);
            $this->em->persist($aide);
            $this->em->flush();
            $this->flasher->addSuccess("Cette nouvelle aide a bien été ajoutée");

            return $this->redirectToRoute("app_dashboard_aide_list");
        }

        return $this->render("espace-comptable/aide/new_aide.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route("/dashboard/aide/delete/{id}", name:"app_dashboard_aide_delete")]
    public function deleteAide(Aide $aide):Response{
        $this->em->remove($aide);
        $this->em->flush();
        $this->flasher->addSuccess("Cette aide à bien été supprimer");
        return $this->redirectToRoute("app_dashboard_aide_list");
    }


    #[Route("/dashboard/aide/edit/{id}", name:"app_dashboard_aide_edit")]
    public function editAide(Request $request, Aide $aide):Response{
        $form = $this->createForm(AideType::class, $aide);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($aide);
            $this->em->flush();
            $this->flasher->addSuccess("Cette nouvelle aide a bien été modifiée");

            return $this->redirectToRoute("app_dashboard_aide_list");
        }

        return $this->render("espace-comptable/aide/edit_aide.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
