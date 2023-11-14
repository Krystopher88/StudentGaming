<?php

namespace App\Controller\Admin;

use App\Entity\Pegi;
use App\Entity\Games;
use App\Entity\Users;
use App\Entity\Orders;
use App\Entity\Stocks;
use App\Entity\Console;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user->getRoles()[0] === 'ROLE_USER') {
            return $this->redirectToRoute('profil_index');
        }

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('StudentGaming')
            ->setTitle('<img src="assets/img/logo.png" alt="logo" width="70px>')
            ->renderContentMaximized()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-users', Users::class );
        yield MenuItem::linkToCrud('jeux videos', 'fa-solid fa-gamepad', Games::class);
        yield MenuItem::linkToCrud('Catégories', 'fa-solid fa-gamepad', Category::class);
        yield MenuItem::linkToCrud('Consoles', 'fa-solid fa-gamepad', Console::class);
        yield MenuItem::linkToCrud('PEGI', 'fa-solid fa-piggy-bank', Pegi::class);
        yield MenuItem::linkToCrud('Stocks', 'fa-solid fa-cubes-stacked', Stocks::class);
        yield MenuItem::linkToCrud('Commandes', 'fa-solid fa-cart-shopping', Orders::class);
    }
}
