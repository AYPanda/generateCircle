<?php

namespace core;


class Router
{

    private $uri;

    private $controller;
    private $action;
    private $params;

    public function __construct($uri)
    {
        if ($uri) {
            $this->uri = $uri;
            $this->getRoute();
        }
    }

    private function getRoute()
    {
        $this->parseRoute();
        $class = "\\controllers\\" . $this->controller . 'Controller';
        $action = $this->action;
        if (class_exists($class)) {
            $controller = new $class();
            if (method_exists($controller, $action)) {
                $controller->$action($this->params);
            } else {
                http_response_code(404);
            }
        } else {
            http_response_code(404);
        }
    }

    private function parseRoute()
    {
        $uri = explode("/", $this->uri);

        $this->controller = isset($uri[1]) && $uri[1] != null ? ucfirst($uri[1]) : "Index";
        $this->action = isset($uri[2]) && $uri[2] != null ? ucfirst($uri[2]) : "Index";
        $this->params = isset($uri[3]) ? $uri[3] : null;
    }
}