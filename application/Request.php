<?php

/*
 * -------------------------------------
 * www.dlancedu.com | Jaisiel Delance
 * framework mvc basico
 * Request.php
 * -------------------------------------
 */


class Request
{
    private $_url;
    private $_modulo;
    private $_lenguaje;
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    private $_modules;
    
    public function __construct() 
    {
        if(isset($_GET['url']))
        {
            $this->_url=$_GET['url'];
            
            $url = str_replace('%20', '(*)', $this->_url);
            $url = filter_var( $url, FILTER_SANITIZE_URL);
            $url = str_replace('(*)', ' ', $this->_url);
         
            $url = explode('/', $url);
            $url = array_filter($url);            
            /* modulos de la app */
            #  $this->_modules = array('usuarios','arquitectura','acl','bitacora','busqueda','visita', 'descarga','dublincore', 'estandar','legislacion','pliniancore', 'darwincore','movil','atlas','excel','calidaddeagua','pecari','hidrogeo', 'rss', 'bdrecursos');
            $_modulos=scandir(ROOT . 'modules');
            $_modulos=array_splice($_modulos, 2);
            $this->_modules  = $_modulos;

            $this->_lenguaje= strtolower(array_shift($url));
            $this->_modulo;
            
            if( strlen($this->_lenguaje)>2)
            {
                 $this->_modulo=$this->_lenguaje;
                 $this->_lenguaje = false;  
            }
            else
            {
                  $this->_modulo=strtolower(array_shift($url));;
            }
      
            if(!$this->_lenguaje)
            {
                 $this->_lenguaje = false;               
            } 

            if(!$this->_modulo)
            {
                $this->_modulo = false;
            }
            
            else
            {
                if(count($this->_modules))
                {                     
                    if(!in_array($this->_modulo, $this->_modules))
                    {
                        $this->_controlador = $this->_modulo;
                        $this->_modulo = false;                        
                    }
                    else
                    {                           
                        $this->_controlador = strtolower(array_shift($url));                      
                        if(!$this->_controlador)
                        {
                            $this->_controlador = 'index';
                        }                      
                    }
                }
                else
                {
                     $this->_controlador = $this->_modulo;
                     $this->_modulo = false;
                }
            }
            
            $this->_metodo = strtolower(array_shift($url));
            $this->_argumentos = $url; 
           
        }       
        
        if(!$this->_controlador)
        {
            $this->_controlador = DEFAULT_CONTROLLER;
        }
        
        if(!$this->_metodo)
        {
            $this->_metodo = 'index';
        }
        
        if(!isset($this->_argumentos))
        {
            $this->_argumentos = array();
        }       
    }
     public function getUrl()
    {
        return $this->_url;
    }
     public function getLenguaje()
    {
        return $this->_lenguaje;
    }
    public function getModulo()
    {
        return $this->_modulo;
    }
    
    public function getControlador()
    {
        return $this->_controlador;
    }
    
    public function getMetodo()
    {
        return $this->_metodo;
    }
    
    public function getArgs()
    {
        return $this->_argumentos;
    }
}

?>