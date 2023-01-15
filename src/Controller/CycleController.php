<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Form\CycleType;
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
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {
        
    }


    #[Route('/dashboard/tontine/cycle', name: 'app_dashboard_cycle')]
    public function getAllCycle(): Response
    {
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
        
        $this->em->remove($cycle);
        $this->em->flush();
        $this->flasher->addSuccess("Ce cycle à bien été supprimé");
        return $this->render("app_dashboard_cycle");
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

}
