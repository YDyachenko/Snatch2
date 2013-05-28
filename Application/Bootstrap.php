<?php

/* Register session handler */

$handler = $this->serviceManager->get('sessionHandler');
session_set_save_handler(
    array($handler, 'open'),
    array($handler, 'close'),
    array($handler, 'read'),
    array($handler, 'write'),
    array($handler, 'destroy'),
    array($handler, 'gc')
);

register_shutdown_function('session_write_close');

session_start();

if ($this->request->getCookie('mobileInterface')) {
    $auth = $this->serviceManager->get('auth');

    $mobile = true;

    if ($auth->isAuthenticated()) {
        /* Check mobile bank is activated or no */
        $userService = $this->serviceManager->get('userService');
        $mobile      = $userService->isMobileBankAllowed($auth->getUser());
    }

    if ($mobile) {
        $this->setOption('mobileInterface', true);
        $this->getLayout()->setLayout('Index.mobile');
    }
}

if ($this->request->getCookie('debug')) {
    $this->setOption('displayExceptions', true);
}