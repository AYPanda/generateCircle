<?php

namespace controllers;

use BL\Repository\AuthorizeRepository;
use core\Controller;

class AuthorizeController extends Controller
{
    private $authorizeRepository;
    public function __construct()
    {
        parent::__construct();
        $this->authorizeRepository = new AuthorizeRepository();
    }

    public function index()
    {
        echo $this->twig->render('authorize.twig');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $login = $_POST["login"];
            $password = $_POST["password"];

            $isAuth = $this->authorizeRepository->login($login, $password);
            if ($isAuth) {
                Send(["error" => false]);
            } else {
                Send(["error" => true, "message" => "Логин или пароль неверен."]);
            }
        }
    }

    public function logout()
    {
        Send($this->authorizeRepository->logout());
    }
}