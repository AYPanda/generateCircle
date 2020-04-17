<?php

namespace controllers;

use core\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index($params)
    {
        echo $this->twig->render('index.twig');
    }
}