<?php

class indexController extends usuariosController {

    private $_usuarios;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_usuarios = $this->loadModel('index');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_usuarios');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Usuarios');
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));

        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');
        $nombre = $this->getSql('nombre');
        // $this->_acl->acceso('admin');
        if ($this->botonPress("bt_guardar")) {
            $this->registrarUsuario();                
        }
        $paginador = new Paginador();
        $this->_view->assign('usuarios', $paginador->paginar($this->_usuarios->getUsuarios(), "listaregistros", "$nombre", $pagina, 25));
        $this->_view->assign('roles', $this->_usuarios->getRoles());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if($PermisoVacio){
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos al Usuario');
        }        
        $this->_view->renderizar('index','usuarios');
    }

    public function _paginacion_listaregistros($nombre = false) {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');

        $condicion = "";
        //$nombre = $this->getSql('nombre');
        if ($nombre) {
            $condicion .= " and Usu_Usuario liKe '%$nombre%' ";
        }

        $paginador = new Paginador();

        $this->_view->assign('usuarios', $paginador->paginar($this->_usuarios->getUsuarios($condicion), "listaregistros", "$nombre", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarUsuario() {
        //$this->validarUrlIdioma();
        $nombre = $this->getSql('palabra');
        $idRol = $this->getInt('idrol');
        //echo $idRol."/".$nombre;exit;
        $condicion = "";

        if ($nombre) {
            $condicion .= " and Usu_Usuario liKe '%$nombre%' ";
        }
        if ($idRol>0) {
            $condicion .= " and u.Rol_IdRol = $idRol ";
        }
       // echo $condicion;exit;
      // print_r($this->_usuarios->getUsuarios($condicion));exit;
        $paginador = new Paginador();

        $this->_view->assign('usuarios', $paginador->paginar($this->_usuarios->getUsuarios($condicion), "listaregistros", "$nombre", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function registrarUsuario()
    {     
        $i=0;
        $error = ""; $error1 = ""; 
        if($this->_usuarios->verificarUsuario($this->getSql('usuario'))){
            $error = ' El usuario <b style="font-size: 1.15em;">' . $this->getAlphaNum('usuario') . '</b> ya existe. ';
            $i=1;
        }
        
        if($this->_usuarios->verificarEmail($this->getSql('email'))){
            if($i!=0) {
                $error1 = '<br> La direccion de correo <b style="font-size: 1.15em;">' . $this->getSql('email') . '</b> ya esta registrada. ';
            }else{
                $error1 = ' La direccion de correo <b style="font-size: 1.15em;">' . $this->getSql('email') . '</b> ya esta registrada. ';
            }
            $i=2;
        }

//        $this->getLibrary('class.phpmailer');
//        $mail = new PHPMailer();
        if($i==0)
        {
            $random = rand(1782598471, 9999999999);
            $idUsuario = $this->_usuarios->registrarUsuario(
                $this->getSql('nombre'),
                $this->getSql('apellidos'),
                $this->getSql('dni'),
                $this->getSql('direccion'),
                $this->getSql('telefono'),
                $this->getSql('institucion'),
                $this->getSql('cargo'),
                $this->getAlphaNum('usuario'),
                $this->getSql('contrasena'),
                $this->getSql('email'),
                45, 1, $random 
            );
        }
        
        if (is_array($idUsuario)) {
            if ($idUsuario[0] > 0) {
                $this->_view->assign('_mensaje', 'Usuario <b style="font-size: 1.15em;">'.$this->getAlphaNum('usuario').'</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar el Usuario');
            }
        } else {
            if($i!=0)
            {
                $this->_view->assign('_error', $error . $error1 );
            }else{
                $this->_view->assign('_error', 'Ocurrio un error al Registrar los datos');
            }            
        }                
    }

    public function _cambiarEstado($idUsusario = false,$estado = false){
        if(!$this->filtrarInt($idUsusario)){            
            $this->_view->assign('_error', 'Error parametro ID ..!!');
            $this->_view->renderizar('index');
            exit;
        }        
        $this->_usuarios->cambiarEstadoUsuario($this->filtrarInt($idUsusario), $this->filtrarInt($estado));
        $this->redireccionar('usuarios');
    }
    public function _eliminarUsuario($Usu_IdUsuario = false) {
        if(!$this->filtrarInt($Usu_IdUsuario)){            
            $this->_view->assign('_error', 'Error parametro ID ..!!');
            $this->_view->renderizar('index'); exit;
        }else{
            $this->_usuarios->eliminarUsuario($this->filtrarInt($Usu_IdUsuario));
        }
        $this->redireccionar('usuarios');
    }
    public function divRol() {
        $this->_view->renderizar('ajax/div_rol', false, true);
    }
    public function divEditContra() {
        $this->_view->assign('idusuario',  $this->getPostParam('idusuario'));
        $this->_view->renderizar('ajax/editarContrasena', false, true);
    }
    
    public function rol($usuarioID, $nuevoRol=false) {
        
        if($nuevoRol){
            $rolID = $this->_usuarios->insertarRol($nuevoRol,'',1);            
            if (is_array($rolID)) {
                if ($rolID  [0] > 0) {
                    $this->_view->assign('_mensaje', 'El Rol <b>'.$nuevoRol.'</b> fue registrado correctamente..!!');
                } else {
                    $this->_view->assign('_error', 'Error al registrar el Rol');
                }
            } else {
               $this->_view->assign('_error', 'Ocurrio un error al Registrar los datos');
            }
        }else{
            $this->validarUrlIdioma();
            $this->_view->getLenguaje("index_inicio");
        }
        $this->_view->setJs(array('index'));

        $id = $this->filtrarInt($usuarioID);
        $condicion='';
        if ($this->botonPress("bt_guardarUsuario")) {
            $this->editarUsuario();               
        }
        if ($this->botonPress("bt_guardarContrasena")) {
            $this->editarUsuario($id);               
        }
        $usu = $this->_usuarios->getUsuario($id);       
        //if ($usu['Rol_IdRol']) {
        //    $condicion .= " and u.Rol_IdRol = ".$usu['Rol_IdRol']." ";
        //}
        //$rolUsuario = $this->_usuarios->getUsuarios($condicion);
        $this->_view->assign('titulo', 'Editar Usuario');        
        $this->_view->assign('idusuario', $id);
        $this->_view->assign('datos', $usu);
        //print_r($usu);
        //$this->_view->assign('rol', $rolUsuario['Rol_role']);
        $this->_view->assign('roles', $this->_usuarios->getRoles());
        if($nuevoRol){
            $this->_view->renderizar('ajax/rol_usuario', false, true);
        }else{
            $this->_view->renderizar('rol');
        }        
    }

    public function permisos($usuarioID) {
        $this->_acl->acceso('agregar_rol');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        //   $this->_acl->acceso('admin');
        $id = $this->filtrarInt($usuarioID);
        
        if (!$id) {
            $this->redireccionar('usuarios');
        }
        if ($this->getInt('guardar') == 1) {
            $values = array_keys($_POST);
            $replace = array();
            $eliminar = array();

            for ($i = 0; $i < count($values); $i++) {
                if (substr($values[$i], 0, 5) == 'perm_') {
                    $permiso = (strlen($values[$i]) - 5);

                    if ($_POST[$values[$i]] == 'x') {
                        $eliminar[] = array(
                            'usuario' => $id,
                            'permiso' => substr($values[$i], -$permiso)
                        );
                    } else {
                        if ($_POST[$values[$i]] == 1) {
                            $v = 1;
                        } else {
                            $v = 0;
                        }
                        $replace[] = array(
                            'usuario' => $id,
                            'permiso' => substr($values[$i], -$permiso),
                            'valor' => $v
                        );
                    }
                }
            }

            for ($i = 0; $i < count($eliminar); $i++) {
                $this->_usuarios->eliminarPermiso(
                        $eliminar[$i]['usuario'], $eliminar[$i]['permiso']);
            }

            for ($i = 0; $i < count($replace); $i++) {
                $this->_usuarios->editarPermiso(
                        $replace[$i]['usuario'], $replace[$i]['permiso'], $replace[$i]['valor']);
            }
            $this->redireccionar('usuarios');
        }

        $permisosUsuario = $this->_usuarios->getPermisosUsuario($id);
        $permisosRole = $this->_usuarios->getPermisosRole($id);
        
        if (!$permisosUsuario || !$permisosRole) {
            $this->redireccionar('usuarios/index/index/vacio');
        }
        ///print_r($permisosUsuario);exit;
        $this->_view->assign('titulo', 'Permisos de usuario');
        $this->_view->assign('permisos', array_keys($permisosUsuario));
        $this->_view->assign('usuario', $permisosUsuario);
        $this->_view->assign('role', $permisosRole);
        $this->_view->assign('info', $this->_usuarios->getUsuario($id));

        $this->_view->renderizar('permisos','permisos');
    }
    
    public function editarUsuario($Usu_IdUsuario = false)
    {     
        $i=0;
        $error = ""; $error1 = ""; 
       /* $usu = $this->_usuarios->verificarUsuario($this->getSql('usuario'));
       // print_r($usu);exit;
        if($usu[0]!=$this->getInt('idusuario')){
            $error = ' El usuario <b style="font-size: 1.15em;">' . $this->getSql('usuario') . '</b> ya existe. ';
            $i=1;
        }      
        */
        if($Usu_IdUsuario){
            $idUsuario = $this->_usuarios->editarUsuarioClave(
                    $this->getSql('contrasena'),
                    $this->getInt('idusuario')
                );

            if ($idUsuario >0) {
                $this->_view->assign('_mensaje', 'Contraseña cambiado correctamente...!!');
            } else {
                $this->_view->assign('_error', 'Error al editar el Contraseña');
            }
        }else{            
            $usuEmail = $this->_usuarios->verificarEmail($this->getSql('email'));

            if(!empty($usuEmail) && $usuEmail['Usu_IdUsuario']!=$this->getInt('idusuario')){
                if($i!=0) {
                    $error1 = '<br> La direccion de correo <b style="font-size: 1.15em;">' . $this->getSql('email') . '</b> ya esta registrada. ';
                }else{
                    $error1 = ' La direccion de correo <b style="font-size: 1.15em;">' . $this->getSql('email') . '</b> ya esta registrada. ';
                }
                $i=2;
            }
               // $random = rand(1782598471, 9999999999);
            if($i==0){      
                $idUsuario = $this->_usuarios->editarUsuario(
                    $this->getSql('nombre'),
                    $this->getSql('apellidos'),
                    $this->getSql('dni'),
                    $this->getSql('direccion'),
                    $this->getSql('telefono'),
                    $this->getSql('institucion'),
                    $this->getSql('cargo'),
                    $this->getSql('email'),
                    $this->getInt('Rol_IdRol'), 
                    $this->getInt('idusuario')
                );
                        
                if ($idUsuario ) {
                    $this->_view->assign('_mensaje', 'Edición del Usuario <b style="font-size: 1.15em;">'.$this->getAlphaNum('usuario').'</b> completado..!!');
                } else {
                    $this->_view->assign('_error', 'Error al editar el Usuario');
                }
            }  else {
                $this->_view->assign('_error', $error.$error1);
            }
        }
    }
}

?>
