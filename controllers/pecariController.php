<?php

class pecariController extends Controller {

    private $_pecari;

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
