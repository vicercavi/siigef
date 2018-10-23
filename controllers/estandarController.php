<?php

class estandarController extends Controller {

    private $_estandar;

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