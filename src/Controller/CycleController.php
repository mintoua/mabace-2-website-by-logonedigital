<?php

namespace App\Controller;

use App\Entity\CalendrierBenef;
use App\Entity\Cycle;
use App\Form\BenefsType;
use App\Form\CycleType;
use App\Repository\CalendrierBenefRepository;
use App\Repository\CycleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class CycleController extends AbstractController
{

    public function __construct(
        private CycleRepository $cycleRepo,
        private CalendrierBenefRepository $calendrierRepo,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {
        
    }


    #[Route('/dashboard/tontine/cycle', name: 'app_dashboard_cycle')]
    public function getAllCycle(): Response
    {
        if(!$this->cycleRepo->findAll())
        {
            $this->flasher->addSuccess("Veuillez d'abord créer au moin une tontine");
            return $this->redirectToRoute("apps_dashboard_tontine");
        }
        return $this->render('espace-comptable/cycle/list_cycle.html.twig', [
            'cycles' => $this->cycleRepo->findAll(),
        ]);
    }

    #[Route("/dashboard/totine/cycle/new", name:"app_dashboard_cycle_new")]
    public function addNewCycle(Request $request):Response{
        $cycle = new Cycle();
        $form = $this->createForm(CycleType::class, $cycle);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $cycle->setCreatedAt( new DateTime("now"));
            $cycle->setEtat(false);
            $this->em->persist($cycle);
            $this->em->flush();
            
            $this->flasher->addSuccess("Ce cycle à bien été ajouté");
            return $this->redirectToRoute("app_dashboard_cycle");
        }

        return $this->render("espace-comptable/cycle/add_cycle.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route("/dashboard/totine/cycle/edit/{id}", name:"app_dashboard_cycle_edit")]
    public function editCycle(Cycle $cycle, Request $request):Response{
        $form = $this->createForm(CycleType::class, $cycle);
        $form->add("etat");
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();
            
            $this->flasher->addSuccess("Ce cycle à bien été modifié");
            return $this->redirectToRoute("app_dashboard_cycle");
        }

        return $this->render("espace-comptable/cycle/edit_cycle.html.twig",[
            "form"=>$form->createView()
        ]);
    }
    
    #[Route("/dashboard/totine/cycle/delete/{id}", name:"app_dashboard_cycle_delete")]
    public function deleteCycle(Cycle $cycle):Response{
        //dd('hello world!');
        $this->em->remove($cycle);
        $this->em->flush();
        $this->flasher->addSuccess("Ce cycle à bien été supprimé");
        return $this->redirectToRoute("app_dashboard_cycle");
    }

    #[Route("/dashboard/totine/cycle/edit_state/{id}", name:"app_dashboard_cycle_edit_state")]
    public function editStateCycle(int $id ):Response{
        $cycle =$this->cycleRepo->find($id);
        if(!$cycle){
            $this->createNotFoundException("ce cycle n'existe pas désolé");
        }
        $cycle->setEtat(true);
        $this->em->flush();
        $this->flasher->addSuccess("Ce cycle à bien été modifié");
        return $this->redirectToRoute("app_dashboard_cycle");
    }

    #[Route("/dashboard/totine/cycle/calendrier_beneficiere/{id}", name:"app_dashboard_cycle_calendrier_benef")]
    public function displayAllCalendrierBenefByCycle(int $id):Response{
        //$calendrierBenef = $this->calendrierRepo->findByCycle($id);
        return $this->render("espace-comptable/calendrier_benef/calendrier_by_cycle.html.twig",[
            "benefs"=>$this->calendrierRepo->findByCycle($id),
            "cycle"=>$this->cycleRepo->find($id),
        ]);
    }

    #[Route("dashboard/tontine/cycle/calendrier_benef_new/{id}", name:"app_dashboard_calendrier_by_cycle")]
    public function addCalendrierByCycle(int $id,Request $request):Response{
         $cycle = $this->cycleRepo->find($id);
         $benef = new CalendrierBenef();
         $form = $this->createForm(BenefsType::class, $benef);
         $form->handleRequest($request);
         if($form->isSubmitted() and $form->isValid()){

            if($this->calendrierRepo->checkRang($id,$benef->getRang())){
                $this->flasher->addError("Ce rang a déjà été attribué à un autre membre dans le cycle courant");
                return $this->redirectToRoute("app_dashboard_calendrier_by_cycle",[
                    "id"=>$id
                ],301);
            }
            $benef->setEtat(false);
            $benef->setCycle($cycle);
            $this->em->persist($benef);
            $this->em->flush();
            $this->flasher->addSuccess("Ce bénéficière à bien été ajouté au calendrier du cycle courant");
            return $this->redirectToRoute("app_dashboard_cycle_calendrier_benef", [
                "id"=>$id
            ],301);
        }

        return $this->render("espace-comptable/calendrier_benef/ajouter-benef.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    

}
