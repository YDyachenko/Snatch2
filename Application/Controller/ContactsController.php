<?php

namespace Application\Controller;

use Core\Mvc\Controller\AbstractActionController;
use Application\Service\Exception\ContactNotFoundException;
use Core\Mvc\Exception\ForbiddenException;

class ContactsController extends AbstractActionController
{
    
    protected $user;
    protected $userService;
    protected $request;

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

        $this->application->getLayout()->setBlock('controller', 'contacts');
        
        $this->user        = $this->serviceManager->get('auth')->getUser();
        $this->userService = $this->serviceManager->get('userService');
        $this->request     = $this->serviceManager->get('request');
    }

    public function indexAction()
    {
        return array(
            'user'     => $this->user,
            'contacts' => $this->userService->fetchUserContacts($this->user)
        );
    }

    public function exportAction()
    {
        $this->application->setOption('disableLayout', true)
                          ->setOption('disableView', true);

        $response = $this->serviceManager->get('response');
        $response->setHeader('Content-type', 'text/xml')
                 ->setHeader('Content-Disposition', 'attachment; filename="contacts.xml"')
                 ->appendBody($this->userService->exportUserContacts($this->user));
    }
    
    public function importAction()
    {
        if (isset($_FILES['contacts'])) {
            $this->userService->importUserContacts($this->user, $_FILES['contacts']['tmp_name']);
        }
        
        $this->redirect('/contacts');
    }
    
    public function addAction()
    {   
        if ($this->request->isPost()){
            $name        = $this->request->getPost('name');
            $account     = $this->request->getPost('account');
            $description = $this->request->getPost('description');
            if (!empty($name) && !empty($account)) {
                $this->userService->addUserContact($this->user, $name, $account, $description);
                $this->redirect('/contacts');
            }
        }
    }
    
    public function deleteAction()
    {   
        $this->userService->deleteUserContact($this->user, $this->request->getParam('id'));
        
        $this->redirect('/contacts');
    }
    
    public function editAction()
    {
        $id = $this->request->getParam('id');
        $contact = $this->userService->fetchContactById($id);
        
        if (!$contact)
            throw new ContactNotFoundException();
        
        if ($contact->user_id != $this->user->id)
            throw new ForbiddenException();
        
        if ($this->request->isPost()) {
            $contact->name        = $this->request->getPost('name');
            $contact->account     = $this->request->getPost('account');
            $contact->description = $this->request->getPost('description');
            
            if ($this->userService->updateContact($contact)) {
                $this->redirect('/contacts');
            }
        }
        
        return array(
            'contact' => $contact
        );
    }

}