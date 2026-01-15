<?php
namespace App\Service;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
        $this->twig = new Environment($loader, [
            'cache' => false
        ]);
    }

    public function render(string $template, array $data = [])
    {
        echo $this->twig->render($template, $data);
    }
}
