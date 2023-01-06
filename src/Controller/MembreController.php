<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Repository\UserRepository;
use App\Services\DefaultService;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{

    public function __construct(
        private UserRepository $userRepo,
        private MemberRepository $memberRepo,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
        private DefaultService $defaultService
    )
    {
        
    }

    #[Route(path:"/dashoard/membre", name:"app_dashboard_member")]
    public function membre():Response{
        return $this->render("espace-comptable/member/member.html.twig",[
            "membres"=>$this->memberRepo->findAll()
        ]);
    }

    #[Route(path:"/dashboard/members/new", name:"app_dashboard_add_member")]
    public function memberAdd(Request $request):Response{
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            
            $this->em->persist($member);
            $this->em->flush();
            $this->flasher->addSuccess("ce membre à bien été ajouter");
            return $this->redirectToRoute("app_dashboard_member");
        }

        return $this->render("espace-comptable/member/member_new.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashoard/member_profil/{matricule}", name:"app_dashboard_member_profil")]
    public function memberDetail(Member $member):Response{

        return $this->render("espace-comptable/member/member_profil.html.twig", [
            "member"=>$member
        ]);
    }

    #[Route(path:"/dashoard/member_delete/{matricule}", name:"app_dashboard_member_delete")]
    public function deleteMember(Member $member):Response{
        $this->em->remove($member);
        $this->em->flush();
        $this->flasher->addSuccess("ce member à bien été supprimer");
        return $this->redirectToRoute("app_dashboard_member");
    }

    #[Route(path:"/dashboard/member_edit/{matricule}", name:"app_dashboard_member_edit")]
    public function editMember(Member $member,Request $request):Response{
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute("app_dashboard_member");
        }

        return $this->render("espace-comptable/member/member_edit.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
