<?php
// core/Controller.php

class Controller
{
    protected $view;
    
    public function view($viewName, $data = [])
    {
        $this->view = $viewName;
        if (!empty($data)) {
            extract($data);
        }
        require_once 'app/views/page/' . $viewName . '.php';
    }
}
?>