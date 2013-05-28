<?php

namespace Application\Service;

use Core\Db\Adapter as DbAdapter;
use Application\Model\User;
use Application\Model\Account;
use Application\Model\Transaction;
use Application\Model\Tan;
use Application\Model\TransactionHistory;
use Application\Model\TransactionTemplate;
use Core\Mvc\Exception\ForbiddenException;

class TransactionService
{
    
    /** @var Core\Db\Adapter */
    protected $db;

    public function setDbAdapter(DbAdapter $db)
    {
        $this->db = $db;

        return $this;
    }
    
    public function createTransaction(User $user, Account $from, Account $to, $sum)
    {
        if ($from->user_id != $user->id)
            throw new ForbiddenException();
        
        $otpCode = '';
        if ($user->otp_method == 'mtan')
            $otpCode = $this->generateMTanCode();
        
        $confirmed = $user->otp_method == 'none' ? 1 : 0;
        
        $this->db->query("INSERT transactions VALUES(null,?,?,?,?,?,?)",
                         $user->id, $from->id, $to->id, $sum, $otpCode, $confirmed);
        
        return $this->fetchTransactionById($this->db->lastInsertId());
    }
    
    public function generateMTanCode()
    {
        $charset = '0123456789';
        $code    = '';

        for ($i = 0; $i < 5; $i++) {
            $code .= $charset[rand(0, 9)];
        }

        return $code;
    }
    
    public function fetchLastUserTan(User $user)
    {
        $tan = $this->_fetchLastUserTan($user);
        if ($tan)
            return $tan;
        
        $this->resetUserTan($user);
        $tan = $this->_fetchLastUserTan($user);
        if ($tan)
            return $tan;
        
        throw new Exception\NoTanAvailableException();
    }
    
    protected function _fetchLastUserTan(User $user)
    {
        $sql = "SELECT * FROM tan WHERE user_id = ? AND used = 0 ORDER BY id DESC LIMIT 1";
        $sth = $this->db->query($sql, $user->id);
        
        if (!$sth->rowCount())
            return false;
        
        $tan = new Tan();
        $tan->populate($sth->fetch());
        
        return $tan;
    }
    
    public function resetUserTan(User $user)
    {
        $this->db->query("UPDATE tan SET used = 0 WHERE user_id = ?", $user->id);
        
        return $this;
    }
    
    public function updateTan(Tan $tan)
    {
        $sql = "UPDATE tan SET code = ?, used = ? WHERE id = ?";
        $this->db->query($sql, $tan->code, $tan->used, $tan->id);
        
        return $this;
    }
    
    public function fetchTransactionById($id)
    {
        $sth = $this->db->query("SELECT * FROM transactions WHERE id = ?", $id);
        if (!$sth->rowCount())
            return false;
        
        $transaction = new Transaction();
        $transaction->populate($sth->fetch());
        
        return $transaction;
    }
    
    public function updateTransaction(Transaction $transaction)
    {
        $sql = "UPDATE transactions SET confirmed = ? WHERE id = ?";
        $this->db->query($sql, $transaction->confirmed, $transaction->id);
        
        return $this;
    }
    
    public function commitTransaction($transactionId, User $user)
    {
        $this->db->beginTransaction();
        
        try {
            $sqlTransaction = "SELECT * FROM transactions WHERE id = ? AND confirmed = 1 FOR UPDATE";
            $sth = $this->db->query($sqlTransaction, $transactionId);
            if (!$sth->rowCount())
                throw new Exception\TransactionNotFoundException();

            $transaction = new Transaction();
            $transaction->populate($sth->fetch());
            
            if ($transaction->user_id != $user->id)
                throw new ForbiddenException();
            
            $sqlAccount = "SELECT * FROM accounts WHERE id = ? FOR UPDATE";
            $sth = $this->db->query($sqlAccount, $transaction->from);
            $accountFrom = $sth->fetch();
            if ($accountFrom['balance'] < $transaction->sum)
                throw new Exception\InsufficientFundsException();

            $this->db->query($sqlAccount, $transaction->to);
            
            $this->db->query("UPDATE accounts SET balance = balance - ? WHERE id = ?",
                             $transaction->sum, $transaction->from);
            
            $this->db->query("UPDATE accounts SET balance = balance + ? WHERE id = ?",
                             $transaction->sum, $transaction->to);
            
            $this->db->query("DELETE FROM transactions WHERE id = ?", $transactionId);
            
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
        
        $this->db->commit();
        
        $this->addTransactionHistory($transaction);
    }
    
    public function addTransactionHistory(Transaction $transaction)
    {
        $sql = "INSERT INTO transactions_history VALUES(?, ?, ?, ?, NOW())";
        $this->db->query($sql, $transaction->id, $transaction->from,
                         $transaction->to, $transaction->sum);
        
        return $this;
    }
    
    public function fetchTransactionsHistory(array $accounts)
    {
        $userAccounts = array();
        foreach ($accounts as $account) {
            $userAccounts[] = (int)$account->id;
        }
        
        $inExpr = implode(',', $userAccounts);
        
        $sql = "SELECT * FROM transactions_history WHERE `from` IN ($inExpr) OR `to` IN($inExpr) ORDER BY `date` DESC";
        $sth = $this->db->query($sql, $inExpr, $inExpr);
        
        if (!$sth->rowCount())
            return array();
        
        $transactions = array();
        $accountsForSelect = array();
        
        while ($item = $sth->fetch()) {
            $transaction = new TransactionHistory();
            $transaction->populate($item);
            
            $transactions[] = $transaction;
            
            $accountsForSelect[] = $transaction->from;
            $accountsForSelect[] = $transaction->to;
        }
        
        $accountsForSelect = array_unique($accountsForSelect);
        
        $sql = "SELECT * FROM accounts WHERE id IN(" . implode(',', $accountsForSelect) . ")";
        $sth = $this->db->query($sql);
        
        $accounts = array();
        
        while ($item = $sth->fetch()) {
            $account = new Account();
            $account->populate($item);
            
            $accounts[$account->id] = $account;
        }
        
        foreach ($transactions as $transaction) {
            $transaction->accountFrom = $accounts[$transaction->from];
            $transaction->accountTo   = $accounts[$transaction->to];
        }
        
        return $transactions;
    }
    
    public function fetchUserTransactions(User $user)
    {
        $sql = "SELECT * FROM transactions WHERE user_id = ?";
        $sth = $this->db->query($sql, $user->id);
        
        if (!$sth->rowCount())
            return array();
        
        $transactions = array();
        $accountsForSelect = array();
        
        while ($item = $sth->fetch()) {
            $transaction = new Transaction();
            $transaction->populate($item);
            
            $transactions[] = $transaction;
            
            $accountsForSelect[] = $transaction->from;
            $accountsForSelect[] = $transaction->to;
        }
        
        $accountsForSelect = array_unique($accountsForSelect);
        
        $sql = "SELECT * FROM accounts WHERE id IN(" . implode(',', $accountsForSelect) . ")";
        $sth = $this->db->query($sql);
        
        $accounts = array();
        
        while ($item = $sth->fetch()) {
            $account = new Account();
            $account->populate($item);
            
            $accounts[$account->id] = $account;
        }
        
        foreach ($transactions as $transaction) {
            $transaction->accountFrom = $accounts[$transaction->from];
            $transaction->accountTo   = $accounts[$transaction->to];
        }
        
        return $transactions;
    }
    
    public function deleteUserTransaction(User $user, $id)
    {
        $transaction = $this->fetchTransactionById($id);
        if (!$transaction) {
            throw new Exception\TransactionNotFoundException();
        }
        
        if ($transaction->user_id != $user->id) {
            throw new ForbiddenException();
        }
        
        $this->db->query("DELETE FROM transactions WHERE id = ?", $id);
        
        return $this;
    }

    public function fetchUserTemplates(User $user)
    {
        $sth = $this->db->query("SELECT * FROM transaction_templates WHERE user_id = ? ", $user->id);
        if (!$sth->rowCount())
            return array();

        $templates = array();

        while ($item = $sth->fetch()) {
            $template = new TransactionTemplate();
            $template->populate($item);

            $templates[] = $template;
        }

        return $templates;
    }
    
    public function fetchTemplateById($id)
    {
        $sth = $this->db->query("SELECT * FROM transaction_templates WHERE id = ? ", $id);
        if (!$sth->rowCount())
            return false;
        
        $template = new TransactionTemplate();
        $template->populate($sth->fetch());
        
        return $template;
    }

    public function addUserTemplate(User $user, $name, $from, $to, $sum)
    {
        $this->db->query("INSERT INTO transaction_templates VALUES(null,?,?,?,?,?)",
                         $user->id, $name, $from, $to, $sum);

        return $this;
    }
    
    public function updateTemplate(TransactionTemplate $template)
    {
        $this->db->query("UPDATE transaction_templates SET name = ?, account_from = ?, account_to = ?, sum = ? WHERE id = ?",
                         $template->name, $template->account_from,
                         $template->account_to, $template->sum, $template->id);
                
        return true;
    }
    
    public function deleteUserTemplate(User $user, $templateId)
    {
        $template = $this->fetchTemplateById($templateId);
        if (!$template) {
            throw new Exception\TransactionTemplateNotFoundException();
        }
        
        if ($template->user_id != $user->id) {
            throw new ForbiddenException();
        }
        
        $this->db->query("DELETE FROM transaction_templates WHERE id = ?", $templateId);
        
        return $this;
    }

}