<?php

namespace core;

use classes\ApiHelper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once(__DIR__ . "/helpers.php");

class Controller
{
    protected $twig;
    private $viewBag = [];

    public function __construct()
    {
        //По хорошему, это должен быть middleware
        if (!$this->isLogin())
        {
            header("Location: /authorize");
            return;
        }
        $loader = new FilesystemLoader("../app/views");
        $this->twig = new Environment($loader, [
            //'cache' => '../app/cache',
            'debug' => true
        ]);
    }

    protected function notFound()
    {
        echo $this->twig->render("404.twig");
        return;
    }

    protected function render($template)
    {
        $this->twig->addGlobal('viewBag', $this->viewBag);
        print_r($this->twig->render($template));
        exit();
    }

    protected function viewBag($key, $value)
    {
        $this->viewBag[$key] = $value;
    }

    private function isLogin()
    {
        if ((isset($_SESSION['id']) && !empty($_SESSION['id'])) || $this->isNotAuthorize()) {
            return true;
        } else {
            return false;
        }
    }
    private function isNotAuthorize()
    {
        return $_SERVER["REQUEST_URI"] == "/authorize" || $_SERVER["REQUEST_URI"] == "/authorize/login";
    }
}