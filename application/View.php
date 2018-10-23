<?php

/*
 * -------------------------------------
 * www.dlancedu.com | Jaisiel Delance
 * framework mvc basico
 * View.php
 * -------------------------------------
 */

require_once ROOT . 'libs' . DS . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php';

class View extends Smarty 
{
    private $_request;
    private $_js;
    private $_css;
    private $_acl;
    private $_rutas;
    private $_jsPlugin;
    private $_template;
    private $_lenguaje;
    private $lenguaje = [];
    private static $_item;
    private $_widget;

    public function __construct(Request $peticion, ACL $_acl) 
    {
        parent::__construct();
        $this->_request = $peticion;
        $this->_js = array();
        $this->_css = array();
        $this->_acl = $_acl;
        $this->_rutas = array();
        $this->_jsPlugin = array();
        $this->_lenguaje = Cookie::lenguaje();
        $this->_template = DEFAULT_LAYOUT;
        self::$_item = null;

        $modulo = $this->_request->getModulo();
        $controlador = $this->_request->getControlador();

        if ($modulo) 
        {
            $this->_rutas['view'] = ROOT . 'modules' . DS . $modulo . DS . 'views' . DS . $controlador . DS;
            $this->_rutas['js'] = BASE_URL . 'modules/' . $modulo . '/views/' . $controlador . '/js/';
            $this->_rutas['css'] = BASE_URL . 'modules/' . $modulo . '/views/' . $controlador . '/css/';
        } 
        else 
        {
            $this->_rutas['view'] = ROOT . 'views' . DS . $controlador . DS;
            $this->_rutas['js'] = BASE_URL . 'views/' . $controlador . '/js/';
            $this->_rutas['css'] = BASE_URL . 'views/' . $controlador . '/css/';
        }
    }

    public static function getViewId() 
    {
        return self::$_item;
    }

    public function renderizar($vista, $item = false, $noLayout = false) 
    {
        if ($item) 
        {
            self::$_item = $item;
        }

        $this->template_dir = ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS;
        $this->config_dir = ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs' . DS;
        $this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
        $this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;

        $js = array();
        $css = array();

        if (count($this->_js)) 
        {
            $js = $this->_js;
        }
        if (count($this->_css)) 
        {
            $css = $this->_css;
        }

        $ruta_base=BASE_URL;

        if(Cookie::lenguaje())
            $ruta_base=BASE_URL. Cookie::lenguaje()."/";

        $_params = array(
            'ruta_css' => BASE_URL . 'views/layout/' . $this->_template . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . $this->_template . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . $this->_template . '/js/',
            'js' => $js,
            'css' => $css,
            'js_plugin' => $this->_jsPlugin,
            'root' =>  $ruta_base,
            'root_clear' => BASE_URL,
            'root_archivo_fisico' => URL_ARCHIVO_FISICO,
            'configs' => $this->getLangNameConfig($this->_lenguaje)
        );

        //$rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl';
        $this->assign('widgets', $this->getWidgets());
        $this->assign('_acl', $this->_acl);
        $this->assign('_layoutParams', $_params);

        $this->getLenguaje("template_".$this->_template);

        if (is_readable($this->_rutas['view'] . $vista . '.tpl')) 
        {
            if ($noLayout) 
            {
                $this->template_dir = $this->_rutas['view'];
                $this->display($this->_rutas['view'] . $vista . '.tpl');
                exit;
            }

            $this->detectVisita();
            $this->assign('_contenido', $this->_rutas['view'] . $vista . '.tpl');
        } 
        else 
        {
            throw new Exception('Error de vista');
        }
        //echo $this->_rutas['view'] . $vista . '.tpl'; exit();

        $this->display('template.tpl');
    }

    public function setJs(array $js) 
    {
        if (is_array($js) && count($js)) 
        {
            for ($i = 0; $i < count($js); $i++) 
            {
                if (is_array($js[$i]) && count($js[$i])) 
                {
                    $this->_js[] = $js[$i][0];
                } 
                else 
                {
                    $this->_js[] = $this->_rutas['js'] . $js[$i] . '.js';
                }               
            }
        } 
        else 
        {
            throw new Exception('Error de js');
        }
    }

    public function setCss(array $css, $externo = false) 
    {
        if (is_array($css) && count($css)) 
        {
            for ($i = 0; $i < count($css); $i++) 
            {
                if (is_array($css[$i]) && count($css[$i])) 
                {
                    $this->_css[] = $css[$i][0];
                } 
                else 
                {
                    $this->_css[] = $this->_rutas['css'] . $css[$i] . '.css';
                }                
            }
        } else 
        {
            throw new Exception('Error de css');
        }
    }

    public function setJsPlugin(array $js) 
    {
        if (is_array($js) && count($js)) 
        {
            for ($i = 0; $i < count($js); $i++) 
            {
                $this->_jsPlugin[] = BASE_URL . 'public/js/' . $js[$i] . '.js';
            }
        } 
        else 
        {
            throw new Exception('Error de js plugin');
        }
    }

    public function setTemplate($template) 
    {
        $this->_template = (string) $template;     
    }

    public function setLenguaje($lang) 
    {
        $this->_lenguaje = (string) $lang;
        $this->getLenguaje("template_" . $this->_template);
    }

    public function getLangNameConfig($lang = false) 
    {
        if ($lang) 
        {
            $lenguaje = $this->LoadLenguaje("config_names", $lang);
            return array(
                'app_name' => $lenguaje["APP_NAME"],
                'app_slogan' => $lenguaje["APP_SLOGAN"],
                'app_company' => $lenguaje["APP_COMPANY"]
            );
        } 
        else 
        {
            return array(
                'app_name' => APP_NAME,
                'app_slogan' => APP_SLOGAN,
                'app_company' => APP_COMPANY
            );
        }
    }

    public function getLenguaje($archivo, $lang = false) 
    {
        if (!is_array($archivo)) 
        {
            $archivo = array($archivo);
        }
        try 
        {
            $lenguaje = Session::get("fileLenguaje");
            foreach ($archivo as $dato) 
            {
                $temp;
                if ($lang)
                    $temp = $this->LoadLenguaje($dato, $lang);
                else
                    $temp = $this->LoadLenguaje($dato);

                //var_dump($temp);
                $lenguaje = array_merge($lenguaje, $temp);
            }

            Session::set("fileLenguaje", $lenguaje);          
            $this->assign('lenguaje', $lenguaje);
        } catch (Exception $ex) 
        {
            throw new Exception('Error Asignar File Lenguaje ' . $ex);
        }
    }

    public function LoadLenguaje($archivo, $lang = false) 
    {
        if ($lang) 
        {
            $this->_lenguaje = (string) $lang;
        }
        $lenguaje_dir = ROOT . 'lenguaje' . DS . $this->_lenguaje . DS . $archivo . "_lang.php";
        if (is_readable($lenguaje_dir)) 
        {
            include $lenguaje_dir;

            if (!isset($lenguaje) || empty($lenguaje))
            {
                $lenguaje = array();
            }
            return $lenguaje;
        }
        else 
        {
            throw new Exception('Error cargar lenguaje');
        }
    }

    public function widget($widget, $method, $options = array()) 
    {
        if (!is_array($options)) 
        {
            $options = array($options);
        }

        if (is_readable(ROOT . 'widgets' . DS . $widget . '.php')) 
        {
            include_once ROOT . 'widgets' . DS . $widget . '.php';

            $widgetClass = $widget . 'Widget';

            if (!class_exists($widgetClass)) 
            {
                throw new Exception('Error clase widget');
            }

            if (is_callable($widgetClass, $method)) 
            {
                if (count($options)) 
                {
                    return call_user_func_array(array(new $widgetClass, $method), $options);
                } else 
                {
                    return call_user_func(array(new $widgetClass, $method));
                }
            }

            throw new Exception('Error metodo widget');
        }

        throw new Exception('Error de widget');
    }

    public function getLayoutPositions() 
    {
        if (is_readable(ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs.php')) 
        {
            include_once ROOT . 'views' . DS . 'layout' . DS . $this->_template . DS . 'configs.php';

            return get_layout_positions();
        }

        throw new Exception('Error configuracion layout');
    }

    private function getWidgets() 
    {
        $widgets = array(
            'menu-sidebar' => array(
                'config' => $this->widget('menu', 'getConfig', array('sidebar')),
                'content' => array('menu', 'getMenu', array('sidebar', 'sidebar'))
            ),
            'menu-top' => array(
                'config' => $this->widget('menu', 'getConfig', array('top')),
                'content' => array('menu', 'getMenu', array('top', 'top'))
            ),
            'menu-footer' => array(
                'config' => $this->widget('menu', 'getConfig', array('footer')),
                'content' => array('menu', 'getMenu', array('footer', 'footer'))
            )
        );

        $positions = $this->getLayoutPositions();
        $keys = array_keys($widgets);

        foreach ($keys as $k) 
        {
            /* verificar si la posicion del widget esta presente */
            if (isset($positions[$widgets[$k]['config']['position']])) 
            {
                /* verificar si esta deshabilitado para la vista */
                if (!isset($widgets[$k]['config']['hide']) || !in_array(self::$_item, $widgets[$k]['config']['hide'])) 
                {
                    /* verificar si esta habilitado para la vista */
                    if ($widgets[$k]['config']['show'] === 'all' || in_array(self::$_item, $widgets[$k]['config']['show'])) 
                    {
                        if (isset($this->_widget[$k])) 
                        {
                            $widgets[$k]['content'][2] = $this->_widget[$k];
                        }

                        /* llenar la posicion del layout */
                        $positions[$widgets[$k]['config']['position']][] = $this->getWidgetContent($widgets[$k]['content']);
                    }
                }
            }
        }

        return $positions;
    }

    public function getWidgetContent(array $content) 
    {
        if (!isset($content[0]) || !isset($content[1])) 
        {
            throw new Exception('Error contenido widget');
            return;
        }

        if (!isset($content[2]))
        {
            $content[2] = array();
        }

        return $this->widget($content[0], $content[1], $content[2]);
    }

    public function setWidgetOptions($key, $options) 
    {
        $this->_widget[$key] = $options;
    }
    
    function detectVisita() 
    {
        $browser = array("IE", "MOZILLA", "NETSCAPE", "FIREFOX", "SAFARI", "CHROME", "OPR", "TRIDENT");
        $os = array("WIN", "MAC", "LINUX");

        # definimos unos valores por defecto para el navegador y el sistema operativo
        $info['browser'] = "OTHER";
        $info['os'] = "OTHER";

        # buscamos el navegador con su sistema operativo
        foreach ($browser as $parent) 
        {
            $b = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
            $t = $b + strlen($parent);
            $version = substr($_SERVER['HTTP_USER_AGENT'], $t, 15);
            $version = preg_replace('/[^0-9,.]/', '', $version);
            if ($b) {
                if ($parent == "TRIDENT") 
                {
                    $info['browser'] = "INTERNET EXPLORER";
                    $info['version'] = $version + 4;
                } 
                else 
                {
                    if ($parent == "SAFARI") 
                    {
                        $info['browser'] = $parent;
                        $b1 = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), 'VERSION');
                        $t1 = $b1 + strlen($parent);
                        $version1 = substr($_SERVER['HTTP_USER_AGENT'], $t1, 15);
                        $version1 = preg_replace('/[^0-9,.]/', '', $version1);
                        $info['version'] = $version1;
                    } 
                    else 
                    {
                        if ($parent == "OPR") 
                        {
                            $info['browser'] = "OPERA";
                            $info['version'] = $version;
                        } 
                        else 
                        {
                            $info['browser'] = $parent;
                            $info['version'] = $version;
                        }
                    }
                }
            }
        }

        # obtenemos el sistema operativo
        foreach ($os as $val) {
            $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $val);
            $a = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $info['browser']);
            $r = $a - $s;
            $f = substr($_SERVER['HTTP_USER_AGENT'], $s - 1, $r);
            if ($s) {
                $info['os'] = $f;
            }
        }

        # devolvemos el array de valores
        $iVis_Explorador = $info["browser"] . ' ' . $info["version"];
        $iVis_PaginaVisita = $_SERVER['REQUEST_URI'];

        if(isset($_SERVER['HTTP_REFERER']))
        {
            $iVis_PaginaAnterior = $_SERVER['HTTP_REFERER'];
        }  
        else 
        {
            $iVis_PaginaAnterior = $iVis_PaginaVisita;
        }
        
        $iVis_SistemaOperativo = $info["os"];
        $iVis_Idioma = Cookie::lenguaje();
        $iVis_Ip = $_SERVER['REMOTE_ADDR'];
        
        $modulo = new Model();
        $modulo->insertarVisita($iVis_Explorador, $iVis_PaginaVisita, $iVis_PaginaAnterior, $iVis_SistemaOperativo, $iVis_Idioma, $iVis_Ip/*, $iVis_Pais, $iVis_Fuente*/);
    }

}

?>
