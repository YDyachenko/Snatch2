<?php

namespace Core\Http;

class Router
{

    protected $request;
    protected $controller = 'Index';
    protected $action     = 'index';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function match()
    {
        $uri = $this->request->getUri();
        $uri = trim($uri, '/');

        $parts = explode('/', $uri);

        if (!empty($parts[0]))
            $this->setController($parts[0]);

        if (!empty($parts[1]))
            $this->setAction($parts[1]);

        $count = count($parts);

        if (count($parts) > 2) {
            for ($i = 2; $i < $count; $i += 2) {
                if (!isset($parts[$i + 1]))
                    break;

                $name  = urldecode($parts[$i]);
                $value = urldecode($parts[$i + 1]);

                $this->request->setParam($name, $value);
            }
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        $controller       = strtolower($controller);
        $controller       = preg_replace('/[^A-Za-z0-9]*/', '', $controller);
        $this->controller = ucfirst($controller);

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $action       = strtolower($action);
        $this->action = $action;

        return $this;
    }

}