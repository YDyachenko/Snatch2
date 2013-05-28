<?php

namespace Core\View;

class View implements ViewInterface
{

    protected $script;
    protected $params = array();
    protected $prefix = 'view';

    public function setScript($script, $prefix = 'view')
    {
        $this->script = 'Application/' . $prefix . '/' . $script . '.phtml';
        return $this;
    }

    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    public function render(array $params = array())
    {
        if (!file_exists($this->script))
            throw new Exception\ScriptNotFound('View script not found: ' . $this->script);

        $params = array_merge($params, $this->params);
        extract($params);

        ob_start();
        include $this->script;
        $return = ob_get_clean();

        return $return;
    }
    
    public function escapeHtml($html)
    {
        return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    }

}