<?php

namespace Application\Service;
use Core\Db\Adapter as DbAdapter;
use Core\Http\Request;
use Application\Service\UserService;
use Application\Model\User;

class AuthService
{

    /** @var Core\Db\Adapter */
    protected $db;
    protected $request;
    protected $user;
    protected $userService;
    
    public function setDbAdapter(DbAdapter $db)
    {
        $this->db = $db;
        
        return $this;
    }
    
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
    
    public function setUserService(UserService $service)
    {
        $this->userService = $service;

        return $this;
    }
    
    public function authenticate($identity, $credential)
    {
        $user = $this->userService->fetchByLogin($identity);
        if (!$user)
            return -1;
        
        if ($user->password != md5($credential))
            return 0;
        
        $_SESSION['user_id'] = $user->id;
        $this->user          = $user;
        
        return 1;
    }
    
    public function isAuthenticated()
    {
        if (empty($_SESSION['user_id']))
            return false;
        
        if (!($this->user instanceof User))
            $this->user = $this->userService->fetchById($_SESSION['user_id']);
        
        return true;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function logout()
    {
        session_destroy();
    }
    
    public function changePassword($password)
    {
        $sql = "UPDATE users SET password = MD5(?), force_change_password = 0 WHERE id = ?";
        $this->db->query($sql, $password, $this->user->id);
        
        $logMessage = sprintf("[%s] #%u new password %s\n", date('Y-m-d H:i:s'),
                              $this->user->id, $password);
        
        file_put_contents('logs/changePassword.log', $logMessage, FILE_APPEND | LOCK_EX);
        
        return $this;
    }

}