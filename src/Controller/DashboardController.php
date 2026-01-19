<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\View;
use App\Model\User;

final class DashboardController
{
    public function __construct(private View $view, private User $users) {}

    public function index(Request $req, int $userId): void
    {
        $user = $this->users->findById($userId);
        $this->view->render('dashboard/index.twig', ['user' => $user]);
    }
}
