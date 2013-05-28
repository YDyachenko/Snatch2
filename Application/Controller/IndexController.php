<?php

namespace Application\Controller;

use Core\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $auth = $this->serviceManager->get('auth');
        if (!$auth->isAuthenticated()) {
            $this->redirect('/auth/login');
        }

        $this->redirect('/account');
    }

    public function switchInterfaceAction()
    {
        $request = $this->serviceManager->get('request');

        if ($request->getCookie('mobileInterface')) {
            setcookie('mobileInterface', '', null, '/');
        } else {
            setcookie('mobileInterface', 'true', null, '/');
        }

        $this->redirect('/');
    }

}