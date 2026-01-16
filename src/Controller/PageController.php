<?php

namespace App\Controller;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class PageController
{
    private Environment $twig;

    function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }


    function loginPage()
    {
        echo $this->twig->render('login.html.twig');
    }
    function homePage()
    {
        echo $this->twig->render('home.html.twig');
    }
}
