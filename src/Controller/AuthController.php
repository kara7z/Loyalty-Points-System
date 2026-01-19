<?php

namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Service\AuthService;

final class AuthController
{
    function __construct(
        private View $view,
        private Response $res,
        private Session $session,
        private AuthService $auth
    ) {}

    function showLogin(Request $req): void
    {
        $this->view->render('auth/login.twig');
    }

    function login(Request $req): void
    {
        try {
            $this->auth->login((string)$req->input('email'), (string)$req->input('password'));
            $this->session->flash('msg', 'Welcome');
            $this->res->redirect('/products');
        } catch (\Throwable $e) {
            $this->session->flash('msg', $e->getMessage());
            $this->res->redirect('/login');
        }
    }

    function showRegister(Request $req): void
    {
        $this->view->render('auth/register.twig');
    }

    function register(Request $req): void
    {
        try {
            $this->auth->register(
                (string)$req->input('email'),
                (string)$req->input('password'),
                $req->input('name')
            );
            $this->session->flash('msg', 'Account created');
            $this->res->redirect('/products');
        } catch (\Throwable $e) {
            $this->session->flash('msg', $e->getMessage());
            $this->res->redirect('/register');
        }
    }

    function logout(Request $req): void
    {
        $this->auth->logout();
        $this->session->flash('msg', 'Logged out');
        $this->res->redirect('/login');
    }
}
