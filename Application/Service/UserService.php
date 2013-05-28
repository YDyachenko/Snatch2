<?php

namespace Application\Service;

use Core\Db\Adapter as DbAdapter;
use Application\Model\User;
use Application\Model\Account;
use Application\Model\Contact;
use Application\Model\Service;
use Core\Mvc\Exception\ForbiddenException;

class UserService
{

    protected $db;

    public function setDbAdapter(DbAdapter $db)
    {
        $this->db = $db;

        return $this;
    }

    public function fetchById($id)
    {
        $sth = $this->db->query("SELECT * FROM users WHERE id = ? ", $id);
        if (!$sth->rowCount())
            return false;

        $user = new User();
        $user->populate($sth->fetch());

        return $user;
    }
    
    public function fetchByLogin($login)
    {
        $sth = $this->db->query("SELECT * FROM users WHERE login = ? ", $login);
        if (!$sth->rowCount())
            return false;

        $user = new User();
        $user->populate($sth->fetch());

        return $user;
    }
    
    public function fetchUserAccounts(User $user)
    {
        $sth = $this->db->query("SELECT * FROM accounts WHERE user_id = ? ", $user->id);
        if (!$sth->rowCount())
            return array();
        
        $accounts = array();
        
        while($item = $sth->fetch()) {
            $account = new Account();
            $account->populate($item);
            
            $accounts[] = $account;
        }

        return $accounts;
    }
    
    public function fetchAccountById($id)
    {
        $sth = $this->db->query("SELECT * FROM accounts WHERE id = ? ", $id);
        if (!$sth->rowCount())
            return false;
        
        $account = new Account();
        $account->populate($sth->fetch());
        
        return $account;
    }
    
    public function fetchAccountByNumber($number)
    {
        $sth = $this->db->query("SELECT * FROM accounts WHERE number = ? ", $number);
        if (!$sth->rowCount())
            return false;
        
        $account = new Account();
        $account->populate($sth->fetch());
        
        return $account;
    }
    
    public function fetchUserContacts(User $user)
    {
        $sth = $this->db->query("SELECT * FROM contacts WHERE user_id = ? ", $user->id);
        if (!$sth->rowCount())
            return array();
        
        $contacts = array();
        
        while($item = $sth->fetch()) {
            $contact = new Contact();
            $contact->populate($item);
            
            $contacts[] = $contact;
        }

        return $contacts;
    }
    
    public function fetchContactById($id)
    {
        $sth = $this->db->query("SELECT * FROM contacts WHERE id = ? ", $id);
        if (!$sth->rowCount())
            return false;
        
        $contact = new Contact();
        $contact->populate($sth->fetch());
        
        return $contact;
    }
    
    public function exportUserContacts(User $user)
    {
        $contacts = $this->fetchUserContacts($user);
        
        $dom = new \DOMDocument('1.0', 'utf-8');
        
        $root = $dom->createElement('contacts');
        $dom->appendChild($root);
        
        foreach ($contacts as $contact) {
            $name        = $dom->createElement('name', $contact->name);
            $account     = $dom->createElement('account', $contact->account);
            $description = $dom->createElement('description', $contact->description);
            
            $contact = $dom->createElement('contact');
            $contact->appendChild($name);
            $contact->appendChild($account);
            $contact->appendChild($description);
            
            $root->appendChild($contact);
        }
        
        return $dom->saveXML();
    }
    
    public function importUserContacts(User $user, $filepath)
    {
        $dom = new \DOMDocument();
        $dom->load($filepath);


        $contacts = $dom->getElementsByTagName('contact');
        
        if (!$contacts->length) {
            return $this;
        }
        
        $this->db->query("DELETE FROM `contacts` WHERE `user_id` = ?", $user->id);
        
        foreach ($contacts as $contact) {
            $name        = $contact->getElementsByTagName('name')->item(0)->nodeValue;
            $account     = $contact->getElementsByTagName('account')->item(0)->nodeValue;
            $description = $contact->getElementsByTagName('description')->item(0)->nodeValue;
            
            $this->addUserContact($user, $name, $account, $description);
        }
        
        return $this;
    }
    
    public function addUserContact(User $user, $name, $account, $description)
    {
        $this->db->query("INSERT INTO contacts VALUES(null,?,?,?,?)",
                         $user->id, $name, $account, $description);
        
        return $this;
    }
    
    public function deleteUserContact(User $user, $contactId)
    {
        $contact = $this->fetchContactById($contactId);
        if (!$contact) {
            throw new Exception\ContactNotFoundException();
        }
        
        if ($contact->user_id != $user->id) {
            throw new ForbiddenException();
        }
        
        $this->db->query("DELETE FROM `contacts` WHERE `id` = ?", $contactId);
    }
    
    public function updateContact(Contact $contact)
    {
        $this->db->query("UPDATE contacts SET name = ?, account = ?, description = ? WHERE id = ?",
                         $contact->name, $contact->account,
                         $contact->description, $contact->id);
                
        return true;
    }
    
    public function sendOtp(User $user, $code)
    {
        $message = 'OTP code: ' . $code;
        
        $logMessage = sprintf("[%s] #%u %s %s\n", date('Y-m-d H:i:s'), $user->id,
                              $user->phone, $message);
        
        file_put_contents('logs/messages.log', $logMessage, FILE_APPEND | LOCK_EX);
        
        /** @TODO Don't forget to send message */
        
        return $this;
    }
    
    public function fetchUserServices(User $user)
    {
        $services = array();
        
        $sql = "SELECT id, name FROM services as s, rel_users_services as r " .
               "WHERE r.service_id = s.id AND r.user_id = ?";
        
        $sth = $this->db->query($sql, $user->id);
        
        while($item = $sth->fetch()) {
            $service = new Service();
            $service->populate($item);
            
            $services[] = $service;
        }
        
        return $services;
    }
    
    public function isMobileBankAllowed(User $user)
    {
        $sql = "SELECT 1 FROM rel_users_services WHERE user_id = ? AND service_id = 1";
        $sth = $this->db->query($sql, $user->id);
        
        return $sth->rowCount() ? true : false;
    }

}