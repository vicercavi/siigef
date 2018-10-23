<?php


class pliniancoreController extends Controller {
    //put your code here
    private $_pliniancore;
    
    public function __construct($lang,$url) 
    {
        parent::__construct($lang,$url);       
    }
    
    public function index()
    {
       $this->validarUrlIdioma();
    }
}
