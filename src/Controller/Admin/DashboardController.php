<?php

namespace App\Controller\Admin;

use App\Entity\CategoryPost;
use App\Entity\Projet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ServiceCategory;
use App\Entity\Service;
use App\Entity\Post;
use App\Entity\Contact;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MA.BA.CE.II');
    }

    public function configureMenuItems(): iterable
    {

        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),
            MenuItem::linkToCrud ('Projets', 'fa fa-tarp',Projet::class),
            MenuItem::section  ('',''),

            MenuItem::subMenu('Blog', 'fas fa-list')->setSubItems([
                MenuItem::linkToCrud('Thématiques blog', 'fa fa-tags', CategoryPost::class),
                MenuItem::linkToCrud('Posts', 'fa fa-file-text', Post::class),
            ]),
            MenuItem::subMenu('Services', 'fas fa-list')->setSubItems([
                 MenuItem::linkToCrud('Categorie', 'fa fa-tags', ServiceCategory::class),
                 MenuItem::linkToCrud('Les Services', 'fas fa-newspaper', Service::class),
            ]),
            MenuItem::section  ('',''),
            MenuItem::linkToCrud('Courriel', 'fas fa-envelope', Contact::class)
            // ...
        ];
    }
}
