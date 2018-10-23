<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mapaController
 *
 * @author ROCAVI
 */
class reportesController extends Controller
{
    private $_mapa;
    public function __construct($lang,$url) {
        parent::__construct($lang,$url);
          $this->_mapa = $this->loadModel('mapa');        
    }

    public function index()
    {
        $this->validarUrlIdioma();
         $this->_view->setJs(array(   
           'highcharts',
             'exporting'));
       $this->_view->assign('titulo', 'Reportes');       
       $this->_view->renderizar('index', 'inicio');
    }
}