<?php

class indexController extends aclController
{
    private $_aclm;
    
    public function __construct($lang,$url) 
    {
        parent::__construct($lang,$url);
        $this->_aclm = $this->loadModel('index');        
    }
    
    public function index()
    {       
        $this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->assign('titulo', 'Listas de acceso');
        
        $this->_view->renderizar('index');
    }
    
    public function roles($pagina=false)
    {
        $this->_acl->acceso('listar_usuarios');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        $nombre = $this->getSql('nombre');
        $pagina = $this->getInt('pagina');
        
        $paginador = new Paginador();
        if ($this->botonPress("bt_guardarRol")) 
        {
              $this->nuevo_role();                
        }
        
        $this->_view->assign('titulo', 'Administracion de roles');
        $this->_view->assign('roles', $paginador->paginar($this->_aclm->getRoles(), "listaregistros", "$nombre", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('roles','aclRoles');
    }
    
    public function _paginacion_listaregistros($nombre = false) 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');

        $condicion = "";
        //$nombre = $this->getSql('nombre');
        if ($nombre) {
            $condicion .= " where Rol_role liKe '%$nombre%' ";
        }

        $paginador = new Paginador();

        $this->_view->assign('roles', $paginador->paginar($this->_aclm->getRoles($condicion), "listaregistros", "$nombre", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _buscarRol() 
    {
        //$this->validarUrlIdioma();
        $nombre = $this->getSql('palabra');
        $condicion = "";

        if ($nombre) {
            $condicion .= " where Rol_role liKe '%$nombre%' ";
        }

        $paginador = new Paginador();

        $this->_view->assign('roles', $paginador->paginar($this->_aclm->getRoles($condicion), "listaregistros", "$nombre", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function nuevo_role($usu=false)
    {
        $this->_acl->acceso('agregar_rol');
        if(!$this->getSql('nuevoRol'))
        {
            if(!$usu)
            {                
                $this->_view->assign('_error','Debe llenar el campo Rol.');
                $this->_view->renderizar('ajax/nuevo_rol', false, true);
            }
        }
        if($this->_aclm->verificarRol($this->getSql('nuevoRol')))
        {
            $this->_view->assign('_error', 'El rol <b style="font-size: 1.15em;">'.$this->getSql('nuevoRol').'</b> ya existe');
        }
        else
        {            
            $idRol = $this->_aclm->insertarRol(
                $this->getSql('nuevoRol'),'',1                
            );  
            if (is_array($idRol)) 
            {
                if ($idRol[0] > 0) 
                {
                    $this->_view->assign('_mensaje', 'Registro Completado..!!');
                } 
                else 
                {
                    $this->_view->assign('_error', 'Error al registrar la Usuario');
                }
            }
            else 
            {
               $this->_view->assign('_error', 'Ocurrio un error al Registrar los datos');
            }
        } 

        if($usu)
        {
            $this->_view->renderizar('ajax/nuevo_rol', false, true);
        }
    }
    
    public function editarRol($Rol_IdRol = false)
    {
        $this->_acl->acceso('editar_rol');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        $rol = $this->_aclm->getRole($this->filtrarInt($Rol_IdRol));
        
        if ($this->botonPress("bt_editarRol")) 
        {            
            if($this->getSql('idIdiomaSeleccionado') == $rol['Idi_IdIdioma'])
            {
                $id = $this->_aclm->editarRole($this->filtrarInt($Rol_IdRol), $this->getSql('editarRol'));
                if($id)
                {
                    $this->_view->assign('_mensaje', 'Rol editado Correctamente');
                    $rol = $this->_aclm->getRole($this->filtrarInt($Rol_IdRol));
                }  
                else 
                {
                    $this->_view->assign('_error', 'Error al editar Rol');
                }
            }  
            else 
            {
                $id = $this->_aclm->editarTraduccion($this->filtrarInt($Rol_IdRol), $this->getSql('editarRol'), $this->getSql('idIdiomaSeleccionado'));
                if($id)
                {
                    $this->_view->assign('_mensaje', 'Traducción de Rol editado Correctamente');
                }  
                else 
                {
                    $this->_view->assign('_error', 'Error al editar Rol');
                }
            }
            //$this->redireccionar('acl/index/roles');
            //exit;
        }        
        $this->_view->assign('idiomas',$this->_aclm->getIdiomas());        
        $this->_view->assign('datos',$rol);
        $this->_view->renderizar('ajax/editarRol','editarRol');
    }        
    
    public function gestion_idiomas_rol() 
    {
        $this->_view->getLenguaje('template_backend');
        $Idi_IdIdioma =  $this->getPostParam('idIdioma');        
        $Rol_IdRol = $this->getPostParam('idrol');
                   
        $datos = $this->_aclm->getRolTraducido($Rol_IdRol, $Idi_IdIdioma);
//        print_r($datos);
        $this->_view->assign('idiomas',$this->_aclm->getIdiomas());
        if ($datos["Idi_IdIdioma"]==$Idi_IdIdioma) 
        {
            $this->_view->assign('datos',$datos);    
        }
        else
        {
            $datos["Rol_role"]="";
            $datos["Idi_IdIdioma"]=$Idi_IdIdioma;
            $this->_view->assign('datos',$datos);  
        }            
        //$this->_view->assign('IdiomaOriginal',$this->getPostParam('idIdiomaOriginal'));        
        $this->_view->renderizar('ajax/gestion_idiomas_rol', false, true);
    }
    
    
    public function _cambiarEstadoRol($idRol = false,$estado = 0)
    {
        $this->_acl->acceso('editar_rol');

        if(!$this->filtrarInt($idRol))
        {            
            $this->_view->assign('_error', 'Error parametro ID ..!!');
            $this->_view->renderizar('index');
            exit;
        }

        $this->_aclm->cambiarEstadoRole($this->filtrarInt($idRol), $this->filtrarInt($estado));
        $this->roles(); 
    }
    public function _eliminarRol($idRol = false)
    {
        $this->_acl->acceso('editar_rol');

        if(!$this->filtrarInt($idRol))
        {            
            $this->_view->assign('_error', 'Error parametro ID ..!!');
            $this->_view->renderizar('index');
            exit;
        }

        $usu = $this->_aclm->getUsuarioRol($this->filtrarInt($idRol));

        if ($usu>0)
        {
            $this->_view->assign('_error', 'No se puede elimnar rol asignado a usuario!!');
        }  
        else 
        {
            $this->_aclm->eliminarRole($this->filtrarInt($idRol));
        }        
        $this->roles();
    }
    
    /*Permisos*/
    /*
    public function editarPermiso($Per_IdPermiso = false){
        $this->_acl->acceso('agregar_rol');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        if ($this->botonPress("bt_editarPermiso")) {
            $id = $this->_aclm->editarPermiso($this->filtrarInt($Per_IdPermiso), $this->getSql('permiso_'), $this->getSql('key_'));
            if($id){
                $this->_view->assign('_mensaje', 'Rol editado Correctamente');
            }  else {
                $this->_view->assign('_error', 'Error al editar Rol');
            }            
            $this->redireccionar('acl/index/permisos');
            exit;
        }
        
        $permiso = $this->_aclm->getPermiso($this->filtrarInt($Per_IdPermiso)); 
        
        $this->_view->assign('datos',$permiso);
        $this->_view->renderizar('ajax/editarPermiso','editarPermiso');
    }
    
    public function gestion_idiomas_permisos() {
        $this->_view->getLenguaje('template_backend');
        $Idi_IdIdioma =  $this->getPostParam('idIdioma');        
        $Per_IdPermiso = $this->getPostParam('idpermisos');
                   
        $datos = $this->_aclm->getPermisoTraducido($Per_IdPermiso, $Idi_IdIdioma);
//        print_r($datos);
        $this->_view->assign('idiomas',$this->_aclm->getIdiomas());
        if ($datos["Idi_IdIdioma"]==$Idi_IdIdioma) {
            $this->_view->assign('datos',$datos);    
        }else{
            $datos["Per_Permiso"]="";
            $datos["Per_Ckey"]="";
            $datos["Idi_IdIdioma"]=$Idi_IdIdioma;
            $this->_view->assign('datos',$datos);  
        }            
        //$this->_view->assign('IdiomaOriginal',$this->getPostParam('idIdiomaOriginal'));        
        $this->_view->renderizar('ajax/gestion_idiomas_permisos', false, true);
    }
    
    public function _cambiarEstadoPermiso($idPermiso = false,$estado = 0){
        $this->_acl->acceso('agregar_rol');
        if(!$this->filtrarInt($idPermiso)){            
            $this->_view->assign('_error', 'Error parametro ID ..!!');
            $this->_view->renderizar('index');
            exit;
        }
        $this->_aclm->cambiarEstadoPermisos($this->filtrarInt($idPermiso), $this->filtrarInt($estado));
        $this->permisos(); 
    }*/
    public function _eliminarPermiso($idPermiso = false)
    {
        $this->_acl->acceso('agregar_rol');
        $error = "";
        if(!$this->filtrarInt($idPermiso))
        {            
            $this->_view->assign('_error', 'Error parametro ID ..!!');
            $this->_view->renderizar('index');
            exit;
        }

        $role = $this->_aclm->verificarPermisoRol($this->filtrarInt($idPermiso));
        //print_r($role);
        if (!$role)
        {
            $usuario = $this->_aclm->verificarPermisoUsuario($this->filtrarInt($idPermiso));
            if(!$usuario){
                $rowCount1 = $this->_aclm->eliminarPermisosRol($this->filtrarInt($idPermiso));
                $rowCount2 = $this->_aclm->eliminarPermisosUsuario($this->filtrarInt($idPermiso));
                $rowCount3 = $this->_aclm->eliminarPermiso($this->filtrarInt($idPermiso));
                echo $rowCount3;//exit;

                if($rowCount3)
                {
                    $error = 1;
                    //$this->_view->assign('_mensaje', 'El permiso fue elimnado correctamente...!!!');
                } 
                else 
                {
                    $error = 'No se pudo eliminar permiso...!!!';
                   // $this->_view->assign('_error', 'No se pudo eliminar permiso...!!!');
                }
                //exit;
            } 
            else 
            {
                $error = 'No se puede eliminar permiso asignado a usuario...!!!';
                //$this->_view->assign('_error', 'No se puede eliminar permiso asignado a usuario...!!!');
            }
            
        }  
        else 
        {
            $error = 'No se puede eliminar permiso asignado a rol...!!!';
           // $this->_view->assign('_error', 'No se puede eliminar permiso asignado a rol...!!!');
          //  echo 'No se puede eliminar permiso asignado a rol...!!!';
          //  exit;
            //$this->_aclm->eliminarRole($this->filtrarInt($idPermiso));
        }  

        $this->redireccionar("acl/index/permisos/".$error);
        //$this->permisos($error);
    }

    public function permisos($error = "")
    {
        $this->_acl->acceso('listar_usuarios');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));

        if($error!="")
        {
            if($error == 1)
            {
                $this->_view->assign('_mensaje', 'El permiso fue elimnado correctamente...!!!');
            }  
            else 
            {
                $this->_view->assign('_error',$error);
            }            
        }
        $nombre = $this->getSql('nombre');
        $pagina = $this->getInt('pagina');
        
        $paginador = new Paginador();
        
        if ($this->botonPress("bt_guardarPermiso")) 
        {
              $this->nuevo_permiso();                
        }
        
        $this->_view->assign('permisos', $paginador->paginar($this->_aclm->getPermisos(), "listarPermisos", "$nombre", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacionPermisos', $paginador->getView('paginacion_ajax'));
        
        $this->_view->assign('titulo', 'Administracion de permisos');
        $this->_view->renderizar('permisos', 'acl');
    }    
    
    public function _paginacion_listarPermisos($nombre = false) 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');

        $condicion = "";
        //$nombre = $this->getSql('nombre');
        if ($nombre) 
        {
            $condicion .= " where Per_Permiso liKe '%$nombre%' ";
        }

        $paginador = new Paginador();

        $this->_view->assign('permisos', $paginador->paginar($this->_aclm->getPermisos($condicion), "listarPermisos", "$nombre", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacionPermisos', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listarPermisos', false, true);
    }
    
    public function _buscarPermiso() 
    {
        //$this->validarUrlIdioma();
        $nombre = $this->getSql('palabra');
        $condicion = "";

        if ($nombre) 
        {
            $condicion .= " where Per_Permiso liKe '%$nombre%' ";
        }

        $paginador = new Paginador();

        $this->_view->assign('permisos', $paginador->paginar($this->_aclm->getPermisos($condicion), "listarPermisos", "$nombre", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacionPermisos', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listarPermisos', false, true);
    }
    
    public function nuevo_permiso()
    {
        $this->_acl->acceso('agregar_rol');
        $i=0;
        $error = ""; $error1 = ""; $error2 = "";
        
        if($this->_aclm->verificarPermiso($this->getSql('permiso_')))
        {
            $error = ' Permiso <b style="font-size: 1.15em;"> '. $this->getSql('permiso_').' </b> ya Existe.';
            $i=1;
        }
        
        if($this->_aclm->verificarKey($this->getAlphaNum('key_')))
        {
            if($i!=0) 
            {
                $error1 = '<br> Key <b style="font-size: 1.15em;">'. $this->getAlphaNum('key_') .' </b> ya existe.';
            }
            else
            {
                $error1 = ' Key <b style="font-size: 1.15em;">'. $this->getAlphaNum('key_') .' </b> ya existe. ';
            }

            $i=2;
        }
        
        if($i==0)
        {
            $idPermiso = $this->_aclm->insertarPermiso(
                $this->getSql('permiso_'), 
                $this->getAlphaNum('key_')
                );
        }
            
        if (is_array($idPermiso)) 
        {
            if ($idPermiso  [0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Se registró correctamente el Permiso <b style="font-size: 1.15em;">'. $this->getSql('permiso_').'</b> ');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el Permiso');
            }
        }
        else 
        {
            if($i!=0)
            {
                $this->_view->assign('_error', $error . $error1 );
            }
            else
            {
                $this->_view->assign('_error', 'Ocurrio un error al Registrar los datos');
            }            
        }            
    }
    
    public function permisos_role($roleID)
    {
        $this->_acl->acceso('agregar_rol');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $id = $this->filtrarInt($roleID);
        
        if(!$id)
        {
            $this->redireccionar('acl/roles');
        }
        
        $row = $this->_aclm->getRole($id);
        
        if(!$row)
        {
            $this->redireccionar('acl/roles');
        }
        
        $this->_view->assign('titulo', 'Administracion de permisos role');
        
        if($this->getInt('guardar') == 1)
        {
            $values = array_keys($_POST);
            $replace = array();
            $eliminar = array();
            
            for($i = 0; $i < count($values); $i++)
            {
                if(substr($values[$i],0,5) == 'perm_')
                {
                    $permiso = (strlen($values[$i]) - 5);
                    
                    if($_POST[$values[$i]] == 'x')
                    {
                        $eliminar[] = array(
                            'role' => $id,
                            'permiso' => substr($values[$i], -$permiso)
                        );
                    }
                    else
                    {
                        if($_POST[$values[$i]] == 1)
                        {
                            $v = 1;
                        }
                        else
                        {
                            $v = 0;
                        }
                        
                        $replace[] = array(
                            'role' => $id,
                            'permiso' => substr($values[$i], -$permiso),
                            'valor' => $v
                        );
                    }
                }
            }
            
            for($i = 0; $i < count($eliminar); $i++)
            {
                $this->_aclm->eliminarPermisoRole(
                        $eliminar[$i]['role'],
                        $eliminar[$i]['permiso']);
            }
            
            for($i = 0; $i < count($replace); $i++)
            {
                $this->_aclm->editarPermisoRole(
                        $replace[$i]['role'],
                        $replace[$i]['permiso'],
                        $replace[$i]['valor']);
            }
        }
        
        $this->_view->assign('role', $row);
        $this->_view->assign('permisos', $this->_aclm->getPermisosRole($id));
        $this->_view->renderizar('permisos_role');
    }
}
?>