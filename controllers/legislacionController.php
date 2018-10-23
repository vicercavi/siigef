<?php

class legislacionController extends Controller {

    private $_legislacion;

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
