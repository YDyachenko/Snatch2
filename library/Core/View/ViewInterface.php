<?php

namespace Core\View;

interface ViewInterface
{

    public function setScript($script);

    public function render(array $params);
    
}