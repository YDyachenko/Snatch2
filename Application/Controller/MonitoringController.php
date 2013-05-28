<?php

namespace Application\Controller;

use Core\Mvc\Controller\AbstractActionController;

class MonitoringController extends AbstractActionController
{

    public function indexAction()
    {
        $layout = $this->application->getLayout();
        $layout->setLayout('Monitoring');

        $db    = $this->serviceManager->get('db');
        $sth   = $db->query("SELECT u.login, a.balance FROM `users` as `u`, `accounts` as `a` WHERE u.id=a.user_id and a.user_id <= 10");
        $users = $sth->fetchAll();

        $sql   = "SELECT SUM(balance) FROM `accounts` WHERE user_id > 10";
        $other = $db->query($sql)->fetchColumn();

        return array(
            'users' => $users,
            'other' => $other
        );
    }

}