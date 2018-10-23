<?php
class bdrecursosController extends Controller 
{
    private $_bdrecursos;
    private $_excel;

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