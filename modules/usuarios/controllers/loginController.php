<?php

class loginController extends Controller {

    private $_login;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
//        $this->_view->setTemplate('backend');
        $this->_login = $this->loadModel('login');
    }

    public function index($url_redirec = false) {

        $this->validarUrlIdioma();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("login_index");

        if (Session::get('autenticado')) {
            $this->redireccionar();
        }
        if (Session::get('login_error')) {
            $this->_view->assign('_error', Session::get('login_error'));
            $this->_view->assign('usuario', Session::get('login_usuario'));
            Session::destroy('login_error');
            Session::destroy('usuario');
        }

        $this->_view->assign('titulo', 'Iniciar Sesion');

        if ($this->botonPress('logear')) {
            $this->_view->assign('usuario', $this->getAlphaNum('usuario'));
            Session::set('login_usuario', $this->getAlphaNum('usuario'));

            $row = $this->_login->getUsuario(
                    $this->getAlphaNum('usuario'), $this->getSql('pass')
            );

            if (!$row) {
                $this->_view->assign('_error', 'Usuario y/o password incorrectos');
                Session::set('login_error', 'Usuario y/o password incorrectos');
            } else
            if ($row['Usu_Estado'] != 1) {
                $this->_view->assign('_error', 'Este usuario no esta habilitado');
                Session::set('login_error', 'Este usuario no esta habilitado');
            } else {

                Session::set('autenticado', true);
                Session::set('level', $row['Rol_IdRol']);
                Session::set('usuario', $row['Usu_Usuario']);
                Session::set('id_usuario', $row['Usu_IdUsuario']);
                Session::set('tiempo', time());

//                if (Session::get('level') == 5) {
//                    $this->redireccionar("acl");
//                }
                $url_redirec=str_replace("*","/",$url_redirec);
                $this->redireccionar($url_redirec);
            }
        } 


        $this->_view->renderizar('index', 'login');    
    }

    public function cerrar() {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        Session::destroy();
        $this->redireccionar();
    }

}

?>
