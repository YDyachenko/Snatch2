<?php

namespace Core\Loader;

class StandardAutoloader
{

    /**
     * @var array Namespace/directory pairs to search; ZF library added by default
     */
    protected $namespaces = array();

    public function __construct()
    {
        $this->registerNamespace('Core', dirname(__DIR__));
    }

    /**
     * Register a namespace/directory pair
     *
     * @param  string $namespace
     * @param  string $directory
     * @return StandardAutoloader
     */
    public function registerNamespace($namespace, $directory)
    {
        $namespace = $namespace . '\\';
        
        $this->namespaces[$namespace] = $this->normalizeDirectory($directory);
        
        return $this;
    }

    /**
     * Defined by Autoloadable; autoload a class
     *
     * @param  string $class
     * @return false|string
     */
    public function autoload($class)
    {
        return $this->loadClass($class);
    }

    /**
     * Register the autoloader with spl_autoload
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Transform the class name to a filename
     *
     * @param  string $class
     * @param  string $directory
     * @return string
     */
    protected function transformClassNameToFilename($class, $directory)
    {
        // $class may contain a namespace portion, in  which case we need
        // to preserve any underscores in that portion.
        $matches = array();
        preg_match('/(?P<namespace>.+\\\)?(?P<class>[^\\\]+$)/', $class, $matches);

        $class     = (isset($matches['class'])) ? $matches['class'] : '';
        $namespace = (isset($matches['namespace'])) ? $matches['namespace'] : '';

        return $directory
                . str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                . str_replace('_', DIRECTORY_SEPARATOR, $class)
                . '.php';
    }

    /**
     * Load a class, based on its type (namespaced or prefixed)
     *
     * @param  string $class
     * @return bool|string
     */
    protected function loadClass($class)
    {
        foreach ($this->namespaces as $namespace => $path) {
            if (0 === strpos($class, $namespace)) {
                $trimmedClass = substr($class, strlen($namespace));

                // create filename
                $filename    = $this->transformClassNameToFilename($trimmedClass, $path);
                $resolveName = stream_resolve_include_path($filename);
                if ($resolveName) {
                    return include $resolveName;
                }

                return false;
            }
        }

        return false;
    }

    /**
     * Normalize the directory to include a trailing directory separator
     *
     * @param  string $directory
     * @return string
     */
    protected function normalizeDirectory($directory)
    {
        $last = $directory[strlen($directory) - 1];
        if (in_array($last, array('/', '\\'))) {
            $directory[strlen($directory) - 1] = DIRECTORY_SEPARATOR;
            return $directory;
        }
        $directory .= DIRECTORY_SEPARATOR;
        return $directory;
    }

}