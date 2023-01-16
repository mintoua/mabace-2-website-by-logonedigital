<?php

namespace App\Controller;

use App\Entity\Beneficiere;
use App\Repository\BeneficiereRepository;
use App\Repository\CalendrierBenefRepository;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BeneficiereController extends AbstractController
{

    public function __construct(
        private BeneficiereRepository $benefRepo,
        private MemberRepository $memberRepository, 
        private EntityManagerInterface $em,
        private CalendrierBenefRepository $calendrierBenefRepo
    ){

    }

    #[Route("dashboard/tontine/cycle/beneficière/{id}", name:"app_dashboard_benef_by_cycle")]
    public function listBenefByCycle(int $id):Response{
        
        return $this->render("espace-comptable/beneficiere/beneficiere.html.twig",[
            "benefs"=>$this->calendrierBenefRepo->listBenefByStateAndCycle($id)
        ]);
    }

    #[Route('/dashboard/beneficiere', name: 'app_dashboard_beneficiere')]
    public function index(): Response
    {

        return $this->render('espace-comptable/beneficiere/beneficiere.html.twig', [
            'benefs' => $this->benefRepo->findAll(),
        ]);
    }

    #[Route("/dashboard/beneficiere/{matricule}/{id}",name:"app_dashboard_add_benef")]
    public function addNewBef(string $matricule, CalendrierBenef $calendrierBenef):Response{
        $benef = new Beneficiere();
        $benef->setMembres($this->memberRepository->findOneByMatricule($matricule));
        $benef->setCalendrierBenef($calendrierBenef);
        $calendrierBenef->setEtat(true);
        $this->em->persist($benef);
        $this->em->flush();
        
        return $this->redirectToRoute("app_dashboard_beneficiere");

    }

    #[Route("/dashboard/beneficiere/supprimer/{id}", name:"app_dashboard_delete_benef")]
    public function deleteBenef(Beneficiere $benef):Response{
        $this->em->remove($benef);
        $this->em->flush();

        return $this->redirectToRoute("app_dashboard_beneficiere");
    }
}
