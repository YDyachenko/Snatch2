<?php

namespace Core\Mvc;

use Core\Config\Config;
use Core\Http;
use Core\ServiceManager\ServiceManager;
use Core\View;

class Application
{
    
    protected $config;
    protected $request;
    protected $response;
    protected $router;
    protected $serviceManager;
    protected $view;
    protected $layout;
    protected $options = array();
    protected $dispatched = false;

    public function __construct()
    {
        $this->config = $this->loadConfig('main');
        $this->initOptions();

        $this->request  = new Http\Request();
        $this->response = new Http\Response();
        
        $this->response->setVersion($this->request->getVersion());
        
        $this->router         = new Http\Router($this->request);
        $this->serviceManager = new ServiceManager();

        $this->initServiceManager();
    }
    
    protected function loadConfig($name)
    {
        $filepath = 'Application/configs/' . $name . '.php';
        if (file_exists($filepath))
            return new Config(include $filepath);
        
        return false;
    }
    
    protected function initServiceManager()
    {
        $this->serviceManager->set('request', $this->request)
                             ->set('response', $this->response)
                             ->set('router', $this->router)
                             ->set('config', $this->config);
        
        $smConfig = $this->loadConfig('serviceManager');
        if ($smConfig && isset($smConfig->factories)) {
            foreach ($smConfig->factories as $name => $factory) {
                $this->serviceManager->setFactory($name, $factory);
            }
        }
    }
    
    protected function initOptions()
    {
        $options = array(
            'disableView'       => false,
            'disableLayout'     => false,
            'displayExceptions' => false,
            'mobileInterface'   => false,
        );
        
        if (isset($this->config->application)) {
            $options = array_merge($options, $this->config->application->toArray());
        }
        
        $this->options = $options;
    }
    
    protected function bootstrap()
    {
        $filepath = 'Application/Bootstrap.php';

        if (file_exists($filepath))
            include $filepath;
    }

    public function run()
    {
        try {
            $this->bootstrap();
        } catch (Exception\HaltException $e) {
            $this->dispatched = true;
        }
        
        $this->router->match();

        $controller = $this->router->getController();
        $action     = $this->router->getAction();
        
        $output = '';
        $obLevel = ob_get_level();
        ob_start();
        
        while (!$this->dispatched) {
            try {
                $output = $this->dispatch($controller, $action);
                $this->dispatched = true;
            } catch (Exception\HaltException $e) {
                /* Nothing to do here */
            } catch (\Exception $e) {
                $controller = 'Error';
                $action     = 'index';
                $this->request->setParam('exception', $e);
                $curObLevel = ob_get_level();
                if ($curObLevel > $obLevel) {
                    do {
                        ob_get_clean();
                        $curObLevel = ob_get_level();
                    } while ($curObLevel > $obLevel);
                }
            }
        }
        
        $output .= ob_get_clean();

        $this->response->appendBody($output);
        
        $this->response->sendHeaders()
                       ->outputBody();
    }
    
    public function dispatch($controller, $action)
    {
        $instance = $this->getController($controller);
        $this->initController($instance);
        
        $method = $action . 'Action';

        if (!method_exists($instance, $method))
            throw new Exception\PageNotFoundException();
        
        $view = $this->getView();
        $view->setScript($controller . '/' . $action);

        $return = call_user_func(array($instance, $method));

        if ($return instanceof View\ViewInterface) {
            $view = $return;
        }
        
        $output = '';

        if (!is_array($return))
            $return = array();

        if (!$this->getOption('disableView')) {
            $output = $view->render($return);
        }
        
        if (!$this->getOption('disableLayout')) {
            try {
                $layout = $this->getLayout();
                $layout->setView($view);
                $layout->setBlock('content', $output);
                $output = $layout->render();
            } catch (\Exception $e) {
                $this->setOption('disableLayout', true);
                throw $e;
            }
        }
        
        return $output;
    }
    
    public function halt()
    {
        $this->dispatched = true;
        throw new Exception\HaltException();
    }


    protected function getController($controller)
    {
        $class = 'Application\\Controller\\' . $controller . 'Controller';
        
        if (class_exists($class))
            return new $class();
        
        throw new Exception\ControllerNotFoundException();
    }
    
    protected function initController($controller)
    {
        if ($controller instanceof Controller\ControllerInterface) {
            $controller->setApplication($this)
                       ->setServiceManager($this->serviceManager);
        }

        if (method_exists($controller, 'init'))
            $controller->init();

        return $this;
    }


    /**
     * 
     * @return Core\View\ViewInterface
     */
    public function getView()
    {
        if ($this->view == null) {
            $this->view = new View\View();
        }
        
        return $this->view;
    }
    
    public function setView(View\ViewInterface $view)
    {
        $this->view = $view;
        
        return $this;
    }
    
    /**
     * 
     * @return Core\View\Layout
     */
    public function getLayout()
    {
        if ($this->layout == null) {
            $this->layout = new View\Layout();
        }
        
        return $this->layout;
    }
    
    public function getOption($name)
    {
        if (isset($this->options[$name]))
            return $this->options[$name];
        
        return false;
    }
    
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        
        return $this;
    }

}