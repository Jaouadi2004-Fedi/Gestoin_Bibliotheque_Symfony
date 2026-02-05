<?php

namespace App\Controller\Admin;

use App\Entity\Borrowing;
use App\Entity\Student;
use App\Controller\Admin\StudentCrudController;
use App\Controller\Admin\BorrowingCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(StudentCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="assets/img/book.png" class="img-fluid d-block mx-auto" style="max-width:100px; width:100%;">
                <h2 class="mt-3 fw-bold text-white text-center">Librarian</h2>')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Student', 'fas fa-chalkboard-teacher', Student::class);
        yield MenuItem::linkToCrud('Borrowing', 'fas fa-book-reader', Borrowing::class);
    }

    #[Route('/admin/borrowing', name: 'admin_borrowing')]
    public function index2(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(BorrowingCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }
}
