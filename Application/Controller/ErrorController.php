<?php

namespace Application\Controller;

use Core\Mvc\Controller\AbstractActionController;
use Core\Mvc\Exception;

class ErrorController extends AbstractActionController
{

    public function init()
    {
        $layout = $this->application->getLayout();
        $layout->setLayout('Error');
    }

    public function indexAction()
    {
        $exception = $this->serviceManager->get('request')->getParam('exception');
        $response  = $this->serviceManager->get('response');
        
        if (!($exception instanceof \Exception)) {
            $exception = new Exception\PageNotFoundException();
        }

        if ($exception instanceof Exception\PageNotFoundException) {
            $response->setStatusCode(404);
            $header = '404. Page not found';
            $message = 'The requested URL was not found on this server.';
        } elseif ($exception instanceof Exception\ForbiddenException) {
            $response->setStatusCode(403);
            $header = '403. Forbidden';
            $message = 'You don\'t have permission to this action.';
        } else {
            $response->setStatusCode(500);
            $header = '500. Internal error';
            $message = 'Sorry, an error occurred while processing your request.';
        }

        $return = array(
            'message' => $message,
            'header' => $header,
        );

        if ($this->application->getOption('displayExceptions')) {
            $return['exception'] = $exception;
        }

        return $return;
    }

}