<?php

namespace Core\Session\SaveHandler;
use Core\Db\Adapter as DbAdapter;

class Db
{
    
    /** @var Core\Db\Adapter */
    protected $db;
    protected $lifetime;
    
    public function setDbAdapter(DbAdapter $db)
    {
        $this->db = $db;
        
        return $this;
    }

    public function close()
    {
        return true;
    }

    public function destroy($sessionId)
    {
        $this->db->query("DELETE FROM sessions WHERE id = ?", $sessionId);
        return true;
    }

    public function gc($maxlifetime)
    {
        $sql = "DELETE FROM sessions WHERE access_time < NOW() - INTERVAL ? SECOND";
        $this->db->query($sql, $maxlifetime);
        
        return true;
    }

    public function open($savePath, $name)
    {
        $this->lifetime = ini_get('session.gc_maxlifetime');
        
        return true;
    }

    public function read($sessionId)
    {
        $sql = "SELECT *, UNIX_TIMESTAMP(access_time) as access_time FROM sessions WHERE id = ? LIMIT 1";
        $sth = $this->db->query($sql, $sessionId);
        
        if ($sth->rowCount()) {
            $row = $sth->fetch();

            if ($row['access_time'] > time() - $this->lifetime) {
                return $row['data'];
            }
            
            $this->destroy($sessionId);
        }
        
        return '';
    }

    public function write($sessionId, $sessionData)
    {
        $sql = "REPLACE sessions VALUES(?, ?, NOW())";
        $sth = $this->db->query($sql, $sessionId, $sessionData);
        
        return true;
    }

}