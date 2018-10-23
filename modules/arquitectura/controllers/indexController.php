<?php

class indexController extends arquitecturaController
{
    private $_arquitectura;

    public function __construct($lang,$url)
    {
        parent::__construct($lang,$url);
        $this->_arquitectura = $this->loadModel('index');
    }

    public function index($padre = 0,$padreconten = false)
    {        
        $this->_acl->acceso('listar_arquitectura_web');        
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->assign('titulo', 'Arquitectura');
        $this->_view->setJs(array('index',array(BASE_URL.'public/ckeditor/ckeditor.js'),array(BASE_URL.'public/ckeditor/adapters/jquery.js')));
                
        $registros  = $this->getInt('registros');
        $pagina = $this->getInt('pagina');
        $tipo = 'todos';
        $nombre = 'todos';
        $condicion ='';
        $condicion1 ='';
        $condicion2 ='';
        
        if ($this->botonPress("guardarPagina1")) {
            $this->registrarPagina();                
        }
        
        if ($this->botonPress("editarPagina1")) {
            $this->editarPagina();                
        }
                
        $id = $this->filtrarInt($padre);
        if ($id > 0) {         
            $condicion1 .= " WHERE Pag_IdPagina = $id ";
            $this->_view->assign('idiomas',$this->_arquitectura->getIdiomas());
            $original = $this->_arquitectura->getPagina($condicion1);
            $Idi_IdIdioma = $original['Idi_IdIdioma'];
            $this->_view->assign('datos',$original);
            $this->_view->assign('original',$original);
        }else{
            $Idi_IdIdioma = Cookie::lenguaje();
            $this->_view->assign('idiomaUrl',$Idi_IdIdioma);
        }
        $idCont = $this->filtrarInt($padreconten);
        if($idCont){
            $condicion2 .= " WHERE Pag_IdPagina = $idCont ";            
            $this->_view->assign('contenido',$this->_arquitectura->getPagina($condicion2));
        }
        $condicion .= " WHERE Pag_IdPrincipal = $id";
        // $this->_acl->acceso('admin');
        $paginador = new Paginador();
//        print_r($original);        
        $this->_view->assign('arquitectura', $paginador->paginar($this->_arquitectura->getPaginas($condicion,$Idi_IdIdioma), "listaregistros", "$tipo/'todos'/$nombre/$Idi_IdIdioma", $pagina,25));
        $this->_view->assign('idiomas',$this->_arquitectura->getIdiomas());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('index','arquitectura');
    }
    
    public function gestion_idiomas() {
        $this->_view->getLenguaje('template_backend');
        $condicion1 ='';
        $Idi_IdIdioma =  $this->getPostParam('idIdioma');
        
        $id = $this->getPostParam('padre');
        
        $condicion1 .= " WHERE Pag_IdPagina = $id ";            
        $datos = $this->_arquitectura->getPaginaTraducida($condicion1,$Idi_IdIdioma);
        $this->_view->assign('idiomas',$this->_arquitectura->getIdiomas());
        if ($datos["Idi_IdIdioma"]==$Idi_IdIdioma) {
            $this->_view->assign('datos',$datos);    
            $this->_view->assign('contenido',$datos);
        }else{
            $datos["Pag_Nombre"]="";
            $datos["Pag_Descripcion"]="";
            $datos["Pag_Contenido"]="";
            $datos["Idi_IdIdioma"]=$Idi_IdIdioma;

            $this->_view->assign('datos',$datos);  
            $this->_view->assign('contenido',$datos);  
        }            
        $this->_view->assign('IdiomaOriginal',$this->getPostParam('idIdiomaOriginal'));
        
        $this->_view->renderizar('ajax/gestion_idiomas', false, true);
    }

    public function _paginacion_listaregistros($tipo = '', $padre = '', $palabra = '', $Idi_IdIdioma='') {
        //$this->validarUrlIdioma();
        $this->_view->getLenguaje('template_backend');
        $pagina = $this->getInt('pagina');
        $registros  = $this->getInt('registros');
        $id = $this->filtrarInt($padre);
        $paginador = new Paginador();
        if($palabra=='todos'){
            $nombre='';
        }
        $this->_view->assign('arquitectura', $paginador->paginar($this->_arquitectura->getBuscarPaginas($id,$tipo,$nombre,$Idi_IdIdioma), "listaregistros", "$tipo/$padre/$palabra/$Idi_IdIdioma", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _buscarPagina($padre = 0) {
        //$this->validarUrlIdioma();
        $this->_view->getLenguaje('template_backend');
        $this->_view->setCss(array('arquitectura'));
        $pagina = $this->getPostParam('pagina');
        $nombre = $this->getSql('palabra');
        if(empty($nombre)){
            $palabra='todos';
        }  else {
            $palabra=$nombre;
        }
        if($padre==0){
            $pad = 'todos';
        }  else {
            $pad = $padre;
        }
        $tipo = $this->getSql('tipo');
        if($tipo==0){
            $tip = 'todos';
        }  else {
            $tip = $tipo;
        }
        $Idi_IdIdioma = $this->getSql('idIdioma');
        if(!$Idi_IdIdioma){
            $Idi_IdIdioma = Cookie::lenguaje();
        }
        
        $id = $this->filtrarInt($padre);
        $paginador = new Paginador();
        
        $this->_view->assign('arquitectura', $paginador->paginar($this->_arquitectura->getBuscarPaginas($id,$tipo,$nombre,$Idi_IdIdioma), "listaregistros", "$tip/$pad/$palabra/$Idi_IdIdioma", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _nuevaArquitectura($padre= 0){
        $this->_view->getLenguaje('template_backend');
        $this->_view->getLenguaje("index_inicio");
        $this->_view->assign('titulo', 'Nueva Arquitectura');
        $condicion1 = '';
        $id=$this->filtrarInt($padre);
               
        $condicion1 .= " WHERE Pag_IdPagina = $id ";

        $this->_view->assign('datos',$this->_arquitectura->getPagina($condicion1));
        
        $this->_view->assign('idPadre',$this->filtrarInt($padre));
        $this->_view->renderizar('ajax/nueva_arquitectura_hijo', false, true);
    }
    
    public function registrarPagina($padre= 0)
    {            
        $i=0;
        $error = ""; $error1 = ""; 
        if($this->_arquitectura->verificarNombrePagina($this->getInt('idPadre'), $this->getSql('nombre'), $this->getInt('posicionPagina'))){
            $error = ' El Nombre <b style="font-size: 1.15em;">'. $this->getSql('nombre').'</b> de Pagina ya Existe en el Tipo de Pagina';
            $i=1;
        }
        if($this->_arquitectura->verificarOrdenPagina($this->getInt('idPadre'), $this->getInt('orden'), $this->getInt('posicionPagina'))){
            if($i!=0) {
                $error1 = '<br> Orden <b style="font-size: 1.15em;">'. $this->getInt('orden').'</b> de Pagina ya Existe en el Tipo de Pagina';
            }else{
                $error1 = ' El Orden <b style="font-size: 1.15em;">'. $this->getInt('orden').'</b> de Pagina ya Existe en el Tipo de Pagina';
            }
            $i=2;
        }
        
        if($i==0){
            $idpagina = $this->_arquitectura->registrarPagina(
                $this->getInt('idPadre'),
                $this->getInt('posicionPagina'),
                'estatica' ,
                $this->getSql('nombre'),
                $this->getSql('descripcion'),                
                $this->getInt('orden'),
                'Sin Contenido',
                $this->getTexto('url'),
                $this->getInt('tipoPagina'),
                1, $this->getSql('idiomaRadio')
            );
        
            if (is_array($idpagina)) {
                if ($idpagina  [0] > 0) {
                    $this->_view->assign('_mensaje', 'Registro Completado..!!');
                } else {
                    $this->_view->assign('_error', 'Error al registrar la Pagina.');
                }
            } else {
                $this->_view->assign('_error', 'Ocurrio un error al Registrar los datos.'.$this->getSql('nombre').'/'.$this->getInt('orden').'/'.$this->getPostParam('idiomaRadio') ."/".$this->getSql('url'));
            }
        }else{
            $this->_view->assign('_error', $error.$error1);
        }
    }
    
    public function editarPagina()
    {            
        $i=0;
        $error = ""; $error1 = ""; 
        if($this->_arquitectura->verificarNombrePagina($this->getInt('idPrincipalEditar'), $this->getSql('nombreEditar'), $this->getInt('posicionEditar'), $this->getInt('idPadreEditar'))){
            $error = ' El Nombre <b style="font-size: 1.15em;">'. $this->getSql('nombreEditar').'</b> de Pagina ya Existe en el Tipo de Pagina';
            $i=1;
        }
        if($this->_arquitectura->verificarIdioma($this->getInt('idPadreEditar'), $this->getSql('idIdiomaEditar')))
        {
            if($this->_arquitectura->verificarOrdenPagina($this->getInt('idPrincipalEditar'), $this->getInt('ordenEditar'), $this->getInt('posicionEditar'), $this->getInt('idPadreEditar'))){
                if($i!=0) {
                    $error1 = '<br> Orden <b style="font-size: 1.15em;">'. $this->getInt('ordenEditar').'</b> de Pagina ya Existe en el Tipo de Pagina';
                }else{
                    $error1 = ' El Orden <b style="font-size: 1.15em;">'. $this->getInt('ordenEditar').'</b> de Pagina ya Existe en el Tipo de Pagina';
                }
                $i=2;
            }
        }
        
        if($i==0){
            if($this->_arquitectura->verificarIdioma($this->getInt('idPadreEditar'), $this->getSql('idIdiomaEditar')))
            {
                $this->_arquitectura->editarPagina(
                    $this->getSql('nombreEditar'),
                    $this->getSql('descripcionEditar'),
                    $this->getInt('ordenEditar'),
                    $this->getTexto('urlEditar'),
                    $this->getPostParam('posicionEditar'),
                    $this->getInt('tipoEditar'),
                    $this->getInt('idPadreEditar')
                );
                $this->_view->assign('_mensaje', 'Edicion Completado..!!');
            }
            else {
                $this->_arquitectura->editarTraduccion(
                $this->getSql('nombreEditar'),
                $this->getSql('descripcionEditar'),
                $this->getInt('idPadreEditar'),
                $this->getSql('idIdiomaEditar')
                );
                $this->_view->assign('_mensaje', 'Edición Traducción Completado..!!');
            }
        }else{
            $this->_view->assign('_error', $error.$error1);
        }
    }
    
    public function _cambiarEstado(){
        $this->_acl->acceso('editar_arquitectura_web');   
        $this->_arquitectura->cambiarEstadoPagina($this->getPostParam("Pag_IdPagina"), $this->getPostParam("Pag_Estado"));
        //$this->_view->assign('_mensaje', 'Pagina Eliminada..!!');
        //$this->redireccionar('arquitectura');
    }
    
    public function registrarContenido(){
      
        $this->_view->getLenguaje("index_inicio");
        
        if($this->getPostParam('idIdioma_') == $this->getPostParam('idIdiomaOriginal_'))
        {
            if($this->getPostParam('editor1') && $this->getInt("padre")){
                $this->_arquitectura->editarContenidoPagina($this->getPostParam('editor1'),$this->getInt("padre"));
                $this->_view->assign('_mensaje',"Contenido Guardado...!!!");
            }        
        }elseif ($this->getPostParam('editor1') && $this->getInt("padre")) {
            
            $this->_arquitectura->editarContenidoTraduccion(
            $this->getPostParam('editor1'),
            $this->getInt("padre"),
            $this->getSql('idIdioma_')
            );
            $this->_view->assign('_mensaje', 'Contenido Traducido Guardado...!!!');
            
        }
        
        $this->_view->renderizar('ajax/registrado', false, true);
    }
    
    
}
?>
