<?php

namespace Core\ServiceManager;

class ServiceManager
{

    /**
     * Lookup for canonicalized names.
     *
     * @var array
     */
    protected $canonicalNames = array();

    /**
     * Registered services and cached values
     *
     * @var array
     */
    protected $instances = array();

    /**
     * @var string|callable|\Closure
     */
    protected $factories = array();
    
    /**
     * @var array map of characters to be replaced through strtr
     */
    protected $canonicalNamesReplacements = array('-' => '', '_' => '', ' ' => '', '\\' => '', '/' => '');

    /**
     * Canonicalize name
     *
     * @param  string $name
     * @return string
     */
    protected function canonicalizeName($name)
    {
        if (isset($this->canonicalNames[$name])) {
            return $this->canonicalNames[$name];
        }

        // this is just for performance instead of using str_replace
        return $this->canonicalNames[$name] = strtolower(strtr($name, $this->canonicalNamesReplacements));
    }

    /**
     * Determine if we can create an instance.
     *
     * @param  string|array $name
     * @return bool
     */
    public function canCreate($name)
    {
        if (is_array($name)) {
            list($cName, $rName) = $name;
        } else {
            $rName = $name;
            $cName = $this->canonicalizeName($rName);
        }

        if (isset($this->factories[$cName])) {
            return true;
        }

        return false;
    }

    /**
     * Create an instance
     *
     * @param  string|array $name
     * @return bool|object
     */
    protected function create($name)
    {
        if (is_array($name)) {
            list($cName, $rName) = $name;
        } else {
            $rName = $name;
            $cName = $this->canonicalizeName($rName);
        }

        return $this->factories[$cName]($this);
    }

    /**
     * Retrieve a registered instance
     *
     * @param  string  $name
     * @throws Exception\ServiceNotFoundException
     * @return object|array
     */
    public function get($name)
    {
        $cName = $this->canonicalizeName($name);

        if (isset($this->instances[$cName])) {
            return $this->instances[$cName];
        }

        if ($this->canCreate(array($cName, $name))) {
            $instance = $this->create(array($cName, $name));

            $this->instances[$cName] = $instance;
            
            return $instance;
        }

        throw new Exception\ServiceNotFoundException();
    }

    /**
     * Check for a registered instance
     *
     * @param  string|array  $name
     * @return bool
     */
    public function has($name)
    {
        $cName = $this->canonicalizeName($name);

        if (isset($this->instances[$cName])) {
            return true;
        }

        if ($this->canCreate(array($cName, $name))) {
            return true;
        }

        return false;
    }

    /**
     * Register a service with the locator
     *
     * @param  string  $name
     * @param  mixed   $service
     * @return ServiceManager
     */
    public function set($name, $service)
    {
        $cName = $this->canonicalizeName($name);

        $this->instances[$cName] = $service;

        return $this;
    }
    
    /**
     * Set factory
     *
     * @param  string                           $name
     * @param  string|FactoryInterface|callable $factory
     * @return ServiceManager
     * @throws Exception\InvalidArgumentException
     */
    public function setFactory($name, $factory)
    {
        $cName = $this->canonicalizeName($name);

        if (!is_callable($factory)) {
            throw new Exception\InvalidArgumentException(
                'Provided abstract factory must be callable.'
            );
        }

        $this->factories[$cName] = $factory;

        return $this;
    }

}