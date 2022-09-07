<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use App\Form\ContactType;
use App\Services\CurlService;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{

    public function __construct (
        private EntityManagerInterface $entityManager,
        private FlasherInterface $flasher
    )
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
    #[Route('/form', name: 'app_form')]
    public function formTemplate(): Response
    {
        return $this->render('default/form_template.html.twig');
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('default/about-us.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $req,
        EntityManagerInterface $em,
    ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);


        $form->handleRequest($req);

        if($form->isSubmitted() and $form->isValid()){

                    $em->persist($contact);
                    $em->flush();
                    $this->flasher->addSuccess("Votre demande a bien été prise en compte.");
                    return $this->redirectToRoute('app_contact');
        }

        return $this->render('default/contact.html.twig', [
            'form'=>$form->createView()
        ]);
    }


}
