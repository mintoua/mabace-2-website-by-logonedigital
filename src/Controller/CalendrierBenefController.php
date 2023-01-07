<?php

namespace App\Controller;

use App\Entity\CalendrierBenef;
use App\Form\BenefsType;
use App\Repository\CalendrierBenefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierBenefController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CalendrierBenefRepository $benefsRepo
    )
    {
        
    }

    #[Route('/dashboard/calendrier_beneficieres', name: 'app_dashboard_calendrier_benef')]
    public function beneficieres(): Response
    {
        return $this->render('espace-comptable/calendrier_benef/calendrier-benef.html.twig', [
            'benefs' => $this->benefsRepo->findAll(),
        ]);
    }

    #[Route(path:"/dashboard/calendrier_beneficieres/add_benef", name:"app_dashboard_calendrier_benef_add")]
    public function addBenef(Request $request):Response
    {
        $benef = new CalendrierBenef();
        $form = $this->createForm(BenefsType::class, $benef);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $benef->setEtat(false);
            $this->em->persist($benef);
            $this->em->flush();
            return $this->redirectToRoute("app_dashboard_calendrier_benef");
        }

        return $this->render("espace-comptable/calendrier_benef/ajouter-benef.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashboard/calendrier_beneficieres/delete/{id}", name:"app_dashboard_calendrier_benef_delete")]
    public function deleteBenef(CalendrierBenef $benef):Response{
        $this->em->remove($benef);
        $this->em->flush();
        return $this->redirectToRoute("app_dashboard_calendrier_benef");
    }



    #[Route(path:"/dashboard/calendrier_beneficieres/update/{id}", name:"app_dashboard_calendrier_benef_update")]
    public function updateBenef(CalendrierBenef $benef, Request $request):Response{

        $form = $this->createForm(BenefsType::class, $benef);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute("app_dashboard_calendrier_benef");
        }

        return $this->render("espace-comptable/calendrier_benef/update-benef.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
