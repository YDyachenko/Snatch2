<?php

use Application\Service\AuthService;
use Core\Db\Adapter as DbAdapter;
use Application\Service\UserService;
use Application\Service\TransactionService;
use Core\Session\SaveHandler\Db as SessionHandler;

return array(
    'factories' => array(
        'db' => function ($sm) {
            $instance = new DbAdapter($sm->get('config')->database->toArray());
            $instance->connect();

            return $instance;
        },
        'userService' => function ($sm) {
            $instantce = new UserService();
            $instantce->setDbAdapter($sm->get('db'));
            
            return $instantce;
        },
        'transactionService' => function ($sm) {
            $instantce = new TransactionService();
            $instantce->setDbAdapter($sm->get('db'));
            
            return $instantce;
        },
        'sessionHandler' => function ($sm) {
            $instantce = new SessionHandler();
            $instantce->setDbAdapter($sm->get('db'));
            
            return $instantce;
        },
        'auth' => function ($sm) {
            $instantce = new AuthService($sm->get('config')->auth);
            $instantce->setDbAdapter($sm->get('db'))
                      ->setRequest($sm->get('request'))
                      ->setUserService($sm->get('userService'));            
            return $instantce;
        }
    )
);