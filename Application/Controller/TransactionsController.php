<?php

namespace Application\Controller;

use Core\Mvc\Controller\AbstractActionController;
use Application\Service\Exception;
use Core\Mvc\Exception\ForbiddenException;

class TransactionsController extends AbstractActionController
{
    
    protected $user;
    /** @var Application\Service\TransactionService */
    protected $tService;
    /** @var Core\Http\Request */
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

        $this->application->getLayout()->setBlock('controller', 'transactions');
        
        $this->user     = $this->serviceManager->get('auth')->getUser();
        $this->tService = $this->serviceManager->get('transactionService');
        $this->request  = $this->serviceManager->get('request');
    }

    public function indexAction()
    {
        $transactions = $this->tService->fetchUserTransactions($this->user);
        
        return array(
            'transactions' => $transactions
        );
    }
    
    public function createAction()
    {
        $userService = $this->serviceManager->get('userService');
        $accounts = $userService->fetchUserAccounts($this->user);
        $return = array(
            'accounts' => $accounts
        );
        
        if ($this->request->isPost()){
            $from = $this->request->getPost('from');
            $to   = $this->request->getPost('to');
            $sum  = $this->request->getPost('sum');
            
            $accountFrom = $userService->fetchAccountById($from);
            $accountTo   = $userService->fetchAccountByNumber($to);
            
            if (!$accountTo) {
                $return['accountToError'] = true;
            }
            
            if ($accountFrom && $accountTo && ($sum > 0)) {
                $transaction = $this->tService->createTransaction($this->user, $accountFrom, $accountTo, $sum);
                
                if ($this->user->otp_method == 'mtan')
                    $userService->sendOtp($this->user, $transaction->otp_code);
                
                $this->redirect('/transactions/confirm/id/' . $transaction->id);
            }
        }
        
        return $return;
    }
    
    public function confirmAction()
    {
        $id = $this->request->getParam('id');
        $transaction = $this->tService->fetchTransactionById($id);
        
        if (!$transaction)
            throw new Exception\TransactionNotFoundException();
        
        if ($transaction->user_id != $this->user->id)
            throw new ForbiddenException();
        
        if ($this->application->getOption('mobileInterface')) {
            $transaction->confirmed = 1;
            $this->tService->updateTransaction($transaction);
        }
        
        if ($transaction->confirmed)
            $this->redirect('/transactions/commit/id/' . $transaction->id);
        
        $userService = $this->serviceManager->get('userService');
        $accountFrom = $userService->fetchAccountById($transaction->from);
        $accountTo   = $userService->fetchAccountById($transaction->to);
        
        $return = array(
            'transaction' => $transaction,
            'accountFrom' => $accountFrom,
            'accountTo'   => $accountTo,
            'otpMethod'   => $this->user->otp_method
        );
        
        if ($this->user->otp_method == 'tan') {
            $tan = $this->tService->fetchLastUserTan($this->user);
            $return['tan'] = $tan;
            
            $cmpCode = $tan->code;
            
        } elseif ($this->user->otp_method == 'mtan') {
            $cmpCode = $transaction->otp_code;
        }
        
        if ($this->request->isPost()) {
            $otp = $this->request->getPost('otp');
            
            if ($otp == $cmpCode) {
                if ($this->user->otp_method == 'tan') {
                    $tan->used = 1;
                    $this->tService->updateTan($tan);
                }
                
                $transaction->confirmed = 1;
                $this->tService->updateTransaction($transaction);
                
                $this->redirect('/transactions/commit/id/' . $transaction->id);
            } else {
                $return['error'] = true;
            }
        }
        
        return $return;
    }
    
    public function commitAction()
    {
        $id = $this->request->getParam('id');
        $transaction = $this->tService->fetchTransactionById($id);
        
        if (!$transaction)
            throw new Exception\TransactionNotFoundException();
        
        if (!$transaction->confirmed)
            $this->redirect('/transactions/confirm/id/' . $transaction->id);
        
        if ($transaction->user_id != $this->user->id)
            throw new ForbiddenException();
        
        $userService = $this->serviceManager->get('userService');
        $accountFrom = $userService->fetchAccountById($transaction->from);
        $accountTo   = $userService->fetchAccountById($transaction->to);
        
        return array(
            'transaction' => $transaction,
            'accountFrom' => $accountFrom,
            'accountTo'   => $accountTo,
        );
    }
    
    public function processAction()
    {
        $id = $this->request->getParam('id');
        try {
            $this->tService->commitTransaction($id, $this->user);
            $this->redirect('/transactions/history');
        } catch(Exception\InsufficientFundsException $e) {
            return array(
                'error' => 'InsufficientFunds'
            );
        }
    }
    
    public function deleteAction()
    {
        $id = $this->request->getParam('id');
        
        $this->tService->deleteUserTransaction($this->user, $id);
        
        $this->redirect('/transactions');
    }

    public function templatesAction()
    {
        return array(
            'user'      => $this->user,
            'templates' => $this->tService->fetchUserTemplates($this->user)
        );
    }
    
    public function addTemplateAction()
    {
        if ($this->request->isPost()){
            $name = $this->request->getPost('name');
            $from = $this->request->getPost('from');
            $to   = $this->request->getPost('to');
            $sum  = $this->request->getPost('sum');
            
            if (!empty($name) && !empty($from) && !empty($to) && ($sum > 0)) {
                $this->tService->addUserTemplate($this->user, $name, $from, $to, $sum);
                $this->redirect('/transactions/templates');
            }
        }
    }
    
    public function editTemplateAction()
    {   
        $template = $this->tService->fetchTemplateById($this->request->getParam('id'));
        
        if (!$template)
            throw new Exception\TransactionTemplateNotFoundException();
        
        if ($this->request->isPost()) {
            $template->name         = $this->request->getPost('name');
            $template->account_from = $this->request->getPost('from');
            $template->account_to   = $this->request->getPost('to');
            $template->sum          = $this->request->getPost('sum');
            
            if ($this->tService->updateTemplate($template)) {
                $this->redirect('/transactions/templates');
            }
        }
        
        return array(
            'template' => $template
        );
    }
    
    public function deleteTemplateAction()
    {
        $id = $this->request->getParam('id');
        
        $this->tService->deleteUserTemplate($this->user, $id);
        
        $this->redirect('/transactions/templates');
    }
    
    public function startFromTemplateAction()
    {
        $id = $this->request->getParam('id');
        $template = $this->tService->fetchTemplateById($id);
        $userService = $this->serviceManager->get('userService');
        
        $accountFrom = $userService->fetchAccountByNumber($template->account_from);
        $accountTo   = $userService->fetchAccountByNumber($template->account_to);
        
        if (!$accountFrom) {
            return array(
                'error' => true,
                'account' => $template->account_from
            );
        }
        
        if (!$accountTo) {
            return array(
                'error' => true,
                'account' => $template->account_to
            );
        }
        
        $transaction = $this->tService->createTransaction($this->user, $accountFrom, $accountTo, $template->sum);
        
        if ($this->user->otp_method == 'mtan')
            $userService->sendOtp($this->user, $transaction->otp_code);
        
        $this->redirect('/transactions/confirm/id/' . $transaction->id);
    }
    
    public function historyAction()
    {
        $userService  = $this->serviceManager->get('userService');
        $accounts     = $userService->fetchUserAccounts($this->user);
        $transactions = $this->tService->fetchTransactionsHistory($accounts);
        
        return array(
            'user'         => $this->user,
            'transactions' => $transactions
        );
    }

}