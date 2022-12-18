<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ServiceRepository;
use Flasher\Prime\FlasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{

    public function __construct (
        private EntityManagerInterface $entityManager,
        private FlasherInterface $flasher,
        private SeoPageInterface $seoPage,
        private UrlGeneratorInterface $urlGenerator,
        private ServiceRepository $serviceRepo,
    )
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $description = "MA.BA.CE.II est une association culturelle au rythme classique qui a vu le jour il y a 50 ans 
        déjà vers les années 70. Elle est basée au Cameroun dans la ville de Yaoundé. Elle regroupe la communauté de bagangté, 
        peuple du Cameroun en pays bamiléké, humble et bienveillant qui se sont réunis pour favoriser les activités des membres, 
        afin de pallier à certaines difficultés rencontrées (chômage).";

        $this->seoPage->setTitle("ASSOCIATION CULTURELLE")
            -> addMeta ('property','og:title','ASSOCIATION CULTURELLE MA.BA.CE.&#x2161')
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('name', 'description', $description)
            ->setLinkCanonical($this->urlGenerator->generate('app_home',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_home',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$description)
            ->setBreadcrumb('Accueil', []);
        
        

        return $this->render('default/index.html.twig', [
            'annonces'=>$this->serviceRepo->findAll()
        ]);
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        $description = "MA.BA.CE.II est une association culturelle au rythme classique qui a vu le jour il y a 50 ans 
        déjà vers les années 70. Elle est basée au Cameroun dans la ville de Yaoundé. Elle regroupe la communauté de bagangté, 
        peuple du Cameroun en pays bamiléké, humble et bienveillant qui se sont réunis pour favoriser les activités des membres, 
        afin de pallier à certaines difficultés rencontrées (chômage).";

        $this->seoPage->setTitle("ASSOCIATION CULTURELLE")
            ->addMeta('property','og:title','ASSOCIATION CULTURELLE MA.BA.CE.&#x2161')
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('name', 'description', $description)
            ->setLinkCanonical($this->urlGenerator->generate('app_about',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_about',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$description)
            ->setBreadcrumb('A propos', []);

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

        if($form->isSubmitted() ){
            if ($form->isValid()){

                $em->persist($contact);
                $em->flush();
                $this->flasher->addSuccess("Votre demande a bien été prise en compte.");
                return $this->redirectToRoute('app_contact');
            }
            else{
                $this->flasher->addError("Formulaire veuillez saisir à nouveau!");
                return $this->redirectToRoute('app_contact');
            }
        }

        $description = "Entrer en contact avec notre association culturelle MA.BA.CE.&#x2161";

        $this->seoPage->setTitle("Contact")
            ->addMeta('property','og:title','ASSOCIATION CULTURELLE MA.BA.CE.&#x2161')
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('name', 'description', $description)
            ->setLinkCanonical($this->urlGenerator->generate('app_contact',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_contact',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$description)
            ->setBreadcrumb('Contact', []);

        return $this->render('default/contact.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/mentions-legales', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('default/mention-legal.html.twig');
    }


}
