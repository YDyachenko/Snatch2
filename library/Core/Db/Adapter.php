<?php

namespace Core\Db;

class Adapter
{

    protected $options;

    protected $instance;

    public function __construct($options)
    {
        $defaults = array(
            'user'     => '',
            'password' => '',
            'host'     => 'locahost',
            'port'     => '3306',
            'dbname'   => '',
        );

        $options = array_merge($defaults, $options);

        foreach ($options as $name => $value)
            $this->setOption($name, $value);
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    public function getOption($name, $default = null)
    {
        if (isset($this->options[$name]))
            return $this->options[$name];

        return $default;
    }

    /**
     * 
     * @return \Core\Db\Adapter
     */
    public function connect()
    {
        $dsn = sprintf('mysql:dbname=%s;host=%s;port=%u;', $this->getOption('dbname'),
                       $this->getOption('host'), $this->getOption('port'));
        
        $this->instance = new \PDO($dsn, $this->getOption('user'),
                                   $this->getOption('password'));
        
        $this->instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        
        return $this;
    }
    
    /**
     * 
     * @return PDOStatement
     */
    public function query()
    {
        $args = func_get_args();
        $sql  = array_shift($args);

        $sth = $this->instance->prepare($sql);

        $sth->execute($args);
        
        return $sth;
    }
    
    public function lastInsertId()
    {
        return $this->instance->lastInsertId();
    }
    
    public function beginTransaction()
    {
        return $this->instance->beginTransaction();
    }
    
    public function commit()
    {
        return $this->instance->commit();
    }
    
    public function rollBack()
    {
        return $this->instance->rollBack();
    }

}