<?php

namespace Application\Controller;

use Core\Mvc\Controller\AbstractActionController;

class AccountController extends AbstractActionController
{

    public function init()
    {
        $auth = $this->serviceManager->get('auth');
        if (!$auth->isAuthenticated()) {
            $this->redirect('/auth/login');
        }
        
        $user = $auth->getUser();
        if ($user->checkForceChangePassword()) {
            $this->redirect('/auth/changePassword');
        }
        
        $this->application->getLayout()->setBlock('controller', 'account');
    }

    public function indexAction()
    {
        $user        = $this->serviceManager->get('auth')->getUser();
        $userService = $this->serviceManager->get('userService');

        return array(
            'user'     => $user,
            'accounts' => $userService->fetchUserAccounts($user),
            'services' => $userService->fetchUserServices($user),
        );
    }

}