<?php

namespace Core\Http;

class Request
{
    protected $version;
    protected $params = array();
    
    public function __construct()
    {
        preg_match('/HTTP\/(\d\.\d)/', $this->getServer('SERVER_PROTOCOL'), $version);
        $this->version = $version[1];
    }

    public function getPost($name, $default = null)
    {
        if (isset($_POST[$name]))
            return $_POST[$name];

        return $default;
    }

    public function getQuery($name, $default = null)
    {
        if (isset($_GET[$name]))
            return $_GET[$name];

        return $default;
    }
    
    public function getCookie($name, $default = null)
    {
        if (isset($_COOKIE[$name]))
            return $_COOKIE[$name];

        return $default;
    }
    
    public function getServer($name, $default = null)
    {
        if (isset($_SERVER[$name]))
            return $_SERVER[$name];

        return $default;
    }
    
    public function getUri()
    {
        $uri = $this->getServer('REQUEST_URI', '/');
        $pos = strpos($uri, '?');
        if ($pos > 0)
            $uri = substr($uri, 0, $pos);
            
        return $uri;
    }
    
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD', 'GET');
    }
    
    public function isPost()
    {
        return strtoupper($this->getMethod()) == 'POST';
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function setVersion($version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    public function getParam($name, $default = null)
    {
        if (isset($this->params[$name]))
            return $this->params[$name];

        return $default;
    }
    
    public function getClientIp($checkProxy = true)
    {
        if ($checkProxy && $this->getServer('HTTP_CLIENT_IP') != null) {
            $ip = $this->getServer('HTTP_CLIENT_IP');
        } else if ($checkProxy && $this->getServer('HTTP_X_FORWARDED_FOR') != null) {
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->getServer('REMOTE_ADDR');
        }

        return $ip;
    }

}