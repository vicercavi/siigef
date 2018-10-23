<?php

class busquedaController extends Controller {
    //put your code here
     private $_busqueda;
    
    public function __construct($lang,$url) 
    {
        parent::__construct($lang,$url);       
    }
    
    public function index()
    {
       $this->validarUrlIdioma();
    }
}
