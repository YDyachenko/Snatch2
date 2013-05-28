<?php

namespace Core\Mvc\Controller;

use Core\ServiceManager\ServiceManager;
use Core\Mvc\Application;

interface ControllerInterface
{

    public function setServiceManager(ServiceManager $sm);

    public function setApplication(Application $application);
    
}