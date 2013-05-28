<?php

namespace Core\View;

class Layout
{

    protected $view;
    protected $blocks = array();
    protected $layout = 'Index';

    public function setView(View $view)
    {
        $this->view = $view;
    }
    
    public function setBlock($name, $value) {
        $this->blocks[$name] = $value;
        
        return $this;
    }
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
        
        return $this;
    }
    
    public function render()
    {
        $this->view->setScript($this->layout, 'layouts');
        return $this->view->render($this->blocks);
    }

}