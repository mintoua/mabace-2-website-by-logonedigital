<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Service;
use App\Services\DefaultService;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProjetController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager,
        private DefaultService $defaultService,
        private SeoPageInterface $seoPage,
        private UrlGeneratorInterface $urlGenerator
    )
    {}

    #[Route('/nos-projets', name: 'app_projet')]
    public function index(Request $request): Response
    {

        $_projects = $this->defaultService->toCache ('projets','1 day',
            $this->entityManager->getRepository (Projet::class)->findAll ());

        $description = "découvrez les projets de MA.BA.CA II";
        $this -> seoPage -> setTitle ( "Projets" )
            -> addMeta ( 'property' , 'og:title' , '' )
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('name', 'description', $description)
            ->addMeta('name', 'keywords', "mabace2, association, projets")
            ->addMeta('property', 'og:title', "projets MA.BA.CE II")
            ->setLinkCanonical($this->urlGenerator->generate('app_projet',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_projet',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$description)
            ->setBreadcrumb('Projets', []);

        $projects = $this->defaultService->toPaginate ($_projects,$request,3) ;

        return $this->render('projet/projets.html.twig', [
            'projets' => $projects,
        ]);
    }

    #[Route('/nos-projets/{slug}', name: 'app_projet_detail')]
    public function projetDetail(Projet $projet): Response
    {
        $this -> seoPage
            -> setTitle( $projet->getIntitule() )
            ->addMeta ( 'property' , 'og:title' , $projet->getSlug() )
            ->addMeta ( 'property' , 'og:type' , 'projet' )
            ->addMeta ( 'name' , 'description' , $projet -> getDescription () )
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta ( 'name' , 'keywords' , $projet->getSlug () )
            ->addMeta('property', 'og:type', 'projet')
            ->addMeta('property', 'og:description', $projet->getDescription())
            ->addMeta('name', 'keywords', "mabace2, MABACE II, MA.BA.CE.&#x2161, association")
            ->addMeta('property', 'og:title', $projet->getSlug())
            ->addMeta('property', 'og:image', "https://mabace-2.com/uploads/images/ProjetsImages/". $projet->getImage())
            ->setLinkCanonical($this->urlGenerator->generate('app_projet_detail',['slug'=>$projet->getSlug ()], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_projet_detail',['slug'=>$projet->getSlug ()], urlGeneratorInterface::ABSOLUTE_URL))
            ->setBreadcrumb('Projets', ["projet"=>$projet]);

        return $this->render('projet/projet-single.html.twig',[
            'bestServices'=>$this->entityManager->getRepository (Service::class)->findByIsBest(1),
            'projet'=>$projet,
        ]);
    }
}
