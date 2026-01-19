<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Service\AuthService;

final class AuthController
{
    public function __construct(
        private View $view,
        private Response $res,
        private Session $session,
        private AuthService $auth
    ) {}

    public function showLogin(Request $req): void
    {
        $this->view->render('auth/login.twig');
    }

    public function login(Request $req): void
    {
        try {
            $this->auth->login((string)$req->input('email'), (string)$req->input('password'));
            $this->session->flash('msg', 'Welcome ✅');
            $this->res->redirect('/products');
        } catch (\Throwable $e) {
            $this->session->flash('msg', $e->getMessage());
            $this->res->redirect('/login');
        }
    }

    public function showRegister(Request $req): void
    {
        $this->view->render('auth/register.twig');
    }

    public function register(Request $req): void
    {
        try {
            $this->auth->register(
                (string)$req->input('email'),
                (string)$req->input('password'),
                $req->input('name')
            );
            $this->session->flash('msg', 'Account created ✅');
            $this->res->redirect('/products');
        } catch (\Throwable $e) {
            $this->session->flash('msg', $e->getMessage());
            $this->res->redirect('/register');
        }
    }

    public function logout(Request $req): void
    {
        $this->auth->logout();
        $this->session->flash('msg', 'Logged out');
        $this->res->redirect('/login');
    }
}
