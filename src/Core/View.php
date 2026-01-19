<?php
namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class View
{
    private Environment $twig;

    public function __construct(string $templatesPath)
    {
        $loader = new FilesystemLoader($templatesPath);
        $this->twig = new Environment($loader, [
            'cache' => false,
            'autoescape' => 'html',
        ]);
    }

    public function globals(array $vars): void
    {
        foreach ($vars as $k => $v) {
            $this->twig->addGlobal($k, $v);
        }
    }

    public function render(string $template, array $params = []): void
    {
        echo $this->twig->render($template, $params);
    }
}
