<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Member;
use App\Entity\Remboursement;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
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
        private EmpruntRepository $empruntRepository
    )
    {}

    #[Route('/dashboard/emprunt', name: 'app_dashboard_emprunts')]
    public function index(): Response
    {
        return $this->render("espace-comptable/emprunt/emprunts.html.twig",[
            "emprunts"=>$this->doctrine->getRepository(Emprunt::class)->findAll()
        ]);
    }

    #[Route(path:"/dashoard/emprunt_detail/{id}", name:"app_dashboard_emprunt_single")]
    public function empruntDetail(Emprunt $emprunt):Response{

        return $this->render("espace-comptable/emprunt/emprunt_single.html.twig", [
            "emprunt"=>$emprunt,
            "remboursements"=>$emprunt->getRemboursements()
        ]);
    }

    #[Route('/dashboard/emprunt/{matricule}', name: 'app_dashboard_add_emprunt')]
    public function addEmprunt(Request $request, Member $member )
    {        
        $emprunt = new Emprunt();

        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){

            $num = count($this->empruntRepository->getEmpruntByTypeOfMember($member->getId(),$emprunt->getType()));
            if($num == 3){
                $this->flasher->addError("Ce membre n'a plus droit à ce type d'emprunt");
            return $this->redirectToRoute('app_dashboard_member');
            }
            $emprunt->setMembre($member);
            $startdate  = strtotime("Today");
            $emprunt->setCreatedAt(date("Y-m-d",$startdate));
            $endedDate = strtotime("+".$emprunt->getDuree()."week",$startdate);
            $emprunt->setEndedAt(date("Y-m-d",$endedDate));
            $emprunt->setEtat(0);
            
            $interet = ( $emprunt->getMontant() * $emprunt->getTauxInteret() ) / $emprunt->getDuree();
            $amortissement = $emprunt->getMontant() / $emprunt->getDuree();
            $hebdomadaire = $interet + $amortissement;

            for ( $week = 1; $week <= $emprunt->getDuree(); $week++){
                $echellon = new Remboursement();
                $echellon->setDate(date("Y-m-d",strtotime("+".$week."week",$startdate)));
                $echellon->setInteret((float)number_format((float)$interet, 3, '.', ''));
                $echellon->setAmortissement((float)number_format((float)$amortissement, 3, '.', ''));
                $echellon->setHebdomadaire((float)number_format((float)$hebdomadaire, 3, '.', ''));
                $echellon->setEtat(0);
                $echellon->setEmprunt($emprunt);
                $emprunt->addRemboursement($echellon);
                $this->em->persist($echellon);
            }

            $this->em->persist($emprunt);
            $this->em->flush();
            
            $this->flasher->addSuccess("Emprunt Attribué avec succés");
            return $this->redirectToRoute('app_dashboard_emprunts');
        }
        return $this->render("espace-comptable/emprunt/emprunt_new.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashboard/emprunt/supprimer/{id}", name:"app_dashboard_emprunt_delete")]
    public function deleteEmprunt(Emprunt $emprunt):Response{
        foreach($emprunt->getRemboursements() as $echeance){
           $this->em->remove($echeance);
        }
        $this->em->remove($emprunt);
        $this->em->flush();
        $this->flasher->addSuccess("Emprunt supprimé");
        return $this->redirectToRoute("app_dashboard_emprunts");
    }

    #[Route(path:"/dashboard/emprunt/modifier/{id}", name:"app_dashboard_emprunt_edit")]
    public function editEmprunt(Emprunt $emprunt,Request $request):Response{

        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute("app_dashboard_emprunts");
        }

        return $this->render("espace-comptable/emprunt/emprunt_new.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
