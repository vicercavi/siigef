<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registrarController
 *
 * @author JHON CHARLIE
 */
class registroController extends dublincoreController{
    //put your code here
    private $_registro;
    
    public function __construct($lang,$url) {
        parent::__construct($lang,$url);
        $this->_registro = $this->loadModel('registro');
    }
    
    public function index($idRecurso = false, $nombreRecurso = false, $cantidaRegistros = false)
    {
        $this->validarUrlIdioma();              
        
        $this->_view->setJs(array('registro'));
        
        $this->_view->assign('idrecurso', $idRecurso);
        $this->_view->assign('nombreRecurso', $nombreRecurso);
        $this->_view->assign('cantidaRegistros', $cantidaRegistros);
        
        $this->_view->assign('titulo', $nombreRecurso);               
        $this->_view->assign('autores', $this->_registro->getAutores());
        $this->_view->assign('temas', $this->_registro->getTemas());
        $this->_view->assign('tipodublin', $this->_registro->getTipoDublin());
        $this->_view->assign('idiomas', $this->_registro->getIdiomas());
        $this->_view->assign('tipoarchivosfisicos', $this->_registro->getTipoArchivosFisicos());
        //$this->_view->assign('documentos', $this->_usuarios->getUsuarios());
        
        
        $this->_view->renderizar('index');
    }
    
    
    
    public function registrarDocumento() {
              
        $this->_view->setJs(array('registro'));
        
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
        {
            //obtenemos el archivo a subir
            $file = $_FILES['archivo']['name'];
            //comprobamos si existe un directorio para subir el archivo
            $src = ROOT_ARCHIVO_FISICO;
            //si no es así, lo creamos
            if(!is_dir($src)) 
                mkdir($src, 0777);        
            
            if(!$this->getSql('titulo')){
                    $this->_view->assign('_error', 'Debe introducir el Titulo');
                    $this->_view->renderizar('index', 'registro');
                    exit;
                }
            if($this->_registro->verificarDublinCore($this->getSql('titulo'))){
                    $this->_view->assign('_error', 'El titulo ' . $this->getAlphaNum('titulo') . ' ya existe');
                    $this->_view->renderizar('index', 'registro');
                    exit;
            }
            
            $idTaf = $this->getInt('formato');
            if($idTaf){
                $condicion = " WHERE Taf_IdTipoArchivoFisico = $idTaf";
            }
            $Taf = $this->_registro->verificarTaf($condicion);
            
            //comprobamos si el archivo ha subido
            if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],$src.$file))
            {
                sleep(3);//retrasamos la petición 3 segundos
                echo $file;//devolvemos el nombre del archivo para pintar la imagen 
                
                $this->_registro->registrarArchivoFisico($Taf['Taf_IdTipoArchivoFisico'],$file,$_FILES['archivo']['size']);
                $Arf = $this->_registro->verificarArf($file);
                
                $this->_registro->registrarDublinCore(
                    $this->getInt('idIdiomaMetadata'),
                    $this->getInt('idTemaDublin'),
                    $this->getInt('idTipoDublin'),
                    $Arf['Arf_IdArchivoFisico'],
                    $this->getInt('recurso'),
                        $this->getSql('idiomaDocumento'),
                        $Taf['Taf_Descripcion'],
                        $this->getSql('titulo'),
                        $this->getSql('descripcion'),
                        $this->getSql('editor'),
                        $this->getSql('colaborador'),
                        $this->getSql('fechaDocumento'),
                        $this->getSql('fuente'),
                        $this->getSql('identificador'),
                        $this->getSql('relacion'),
                        $this->getSql('cobertura'),
                        $this->getSql('palabraclave'),
                        $this->getSql('derechos')
                    );
                
                $dublinCore = $this->_registro->verificarDublinCore($this->getSql('titulo'));                
                $this->_registro->registrarDublinCoreAutor($dublinCore['Dub_IdDublinCore'],$this->getInt('idAutor'));
                $this->_registro->getCantidadRegistros($this->getInt('cantidadRegistros')+1,$this->getInt('recurso'));
                $this->_view->assign('_mensaje', "Registro Completado.. ". $dublinCore['Dub_IdDublinCore']."/".$this->getInt('idAutor')."");        
            
                $this->redireccionar('bdrecursos');
            }           
        
        }else{
            throw new Exception("Error Processing Request", 1);   
        }
        
        
    }
    public function nuevoIdioma()
    {        
        //$this->_view->setJs(array('registro'));
       
        if($this->getInt("registrar") == 1)
        {
            if(!$this->getSql('idiomanombre')){
                    $this->_view->assign('_error', 'Debe introducir el Idioma');
                    $this->_view->renderizar('nuevo_idioma');
                    exit;
            }
            $this->_registro->registrarNuevoIdioma($this->getSql('idiomanombre'));
            
            $this->redireccionar('dublincore/registro');
        }
        $this->_view->renderizar('nuevo_idioma');
    }
    
    public function nuevoTema()
    {        
        //$this->_view->setJs(array('registro'));
    
        if($this->getInt("registrar") == 1)
        {
            if(!$this->getSql('temanombre')){
                    $this->_view->assign('_error', 'Debe introducir el Idioma');
                    $this->_view->renderizar('nuevo_tema');
                    exit;
            }
            $this->_registro->registrarNuevoTema($this->getSql('temanombre'));
            
            $this->redireccionar('dublincore/registro');
        }
        $this->_view->renderizar('nuevo_tema');
    }
    
    public function nuevoAutor()
    {        
        //$this->_view->setJs(array('registro'));
    
        if($this->getInt("registrar") == 1)
        {
            if(!$this->getSql('autornombre')){
                    $this->_view->assign('_error', 'Debe introducir el Nombre Autor');
                    $this->_view->renderizar('nuevo_autor');
                    exit;
            }
            if(!$this->getSql('autorprofesion')){
                    $this->_view->assign('_error', 'Debe introducir el Nombre Autor');
                    $this->_view->renderizar('nuevo_autor');
                    exit;
            }
            if(!$this->getSql('autoremail')){
                    $this->_view->assign('_error', 'Debe introducir el Nombre Autor');
                    $this->_view->renderizar('nuevo_autor');
                    exit;
            }
            $this->_registro->registrarNuevoAutor($this->getSql('autornombre'),
                    $this->getSql('autorprofesion'),
                    $this->getSql('autoremail'));
            
            $this->redireccionar('dublincore/registro');
        }
        $this->_view->renderizar('nuevo_autor');
    }
    
    public function nuevoFormato()
    {        
        //$this->_view->setJs(array('registro'));
 
        if($this->getInt("registrar") == 1)
        {
            if(!$this->getSql('formatonombre')){
                    $this->_view->assign('_error', 'Debe introducir el Nombre Formato');
                    $this->_view->renderizar('nuevo_formato');
                    exit;
            }
            $this->_registro->registrarNuevoFormato($this->getSql('formatonombre'));
            
            $this->redireccionar('dublincore/registro');
        }
        $this->_view->renderizar('nuevo_formato');
    }
    
    public function nuevoTipoDocumento()
    {        
        //$this->_view->setJs(array('registro'));
       
        if($this->getInt("registrar") == 1)
        {
            if(!$this->getSql('tiponombre')){
                    $this->_view->assign('_error', 'Debe introducir el Nombre Tipo Documento');
                    $this->_view->renderizar('nuevo_tipo_documento');
                    exit;
            }
            if(!$this->getSql('tipoidioma')){
                    $this->_view->assign('_error', 'Debe introducir el Idioma Tipo Documento');
                    $this->_view->renderizar('nuevo_tipo_documento');
                    exit;
            }
            $this->_registro->registrarNuevoTipoDocumento($this->getSql('tiponombre'),
                    $this->getSql('tipoidioma'));
            
            $this->redireccionar('dublincore/registro');
        }
        $this->_view->renderizar('nuevo_tipo_documento');
    }
    
}                                                       
