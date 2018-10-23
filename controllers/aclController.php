<?php

class aclController extends Controller
{
    private $_aclm;
    
    public function __construct($lang,$url) 
    {
        parent::__construct($lang,$url);       
    }
    
    public function index()
    {       
        $this->validarUrlIdioma();
    }      
}

?>
