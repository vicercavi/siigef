<?php
class arquitecturaController extends Controller
{
    private $_arquitectura;

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
