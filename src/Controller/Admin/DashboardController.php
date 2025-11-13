<?php

namespace App\Controller\Admin;
use App\Entity\Borrowing;
use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]

    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(StudentCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
{
return Dashboard::new()
->setTitle('<img src="assets/img/book.png" class="img-fluid d-block mxauto" style="max-width:100px; width:100%;"><h2 class="mt-3 fw-bold text-white
text-center">Librarian</h2>')
->renderContentMaximized();
}

    public function configureMenuItems(): iterable
    {
       yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
yield MenuItem::linkToCrud('Student', 'fas fa-chalkboard-teacher',
Student::class);
yield MenuItem::linkToCrud('Borrowing', 'fas fa-book-reader', Borrowing::class);

    }


    #[Route('/admin/borrowing', name: 'admin_borrowing')]
    public function index2(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(BorrowingCrudController::class)->generateUrl();
        return $this->redirect($url);
    }
}
