<?php

/*
 * + --------------------------------------------------------- +
 * |  Software:	Paginador - clase PHP para paginar registros   |
 * |   Versi�n:	1.0											   |
 * |  Licencia:	Distribuido de forma libre					   |
 * |     Autor:	Jaisiel Delance								   |
 * | Sitio Web:	http://www.dlancedu.com						   |
 * + --------------------------------------------------------- +
 *
 */

class Paginador {

    private $_datos;
    private $_paginacion;
    private $_numero_pagina;
    private $_control_paginacion;
    private $_nombrelista;
    private $_parametros;
    private $_lenguaje;

    public function __construct() {
        $this->_datos = array();
        $this->_paginacion = array();
        $this->_lenguaje = $this->LoadLenguaje();
    }

    public function paginar($query, $nombrelista, $parametros, $pagina = false, $limite = false, $paginacion = false) {
        $this->_nombrelista = $nombrelista;
        $this->_parametros = $parametros;
        if ($limite && is_numeric($limite)) {
            $limite = $limite;
        } else {
            $limite = 10;
        }

        if ($pagina && is_numeric($pagina)) {
            $pagina = $pagina;
            $inicio = ($pagina - 1) * $limite;
        } else {
            $pagina = 1;
            $inicio = 0;
        }


        $registros = count($query);
        $total = ceil($registros / $limite);
        $this->_datos = array_slice($query, $inicio, $limite);


        $paginacion = array();
        $paginacion['actual'] = $pagina;
        $paginacion['total'] = $total;

        //-----------------------------
        $this->_numero_pagina = $pagina * $limite - ($limite - 1);

        if ($pagina == $total) {
            $paginacion['actual_registro'] = $registros;
        } else {
            $paginacion['actual_registro'] = $pagina * $limite;
        }


        $paginacion['total_registro'] = $registros;

        //Mejorar...........
        $this->_control_paginacion = $paginacion['actual_registro'] . " de " . $paginacion['total_registro'];
        //---------------------------------
        if ($pagina > 1) {
            $paginacion['primero'] = 1;
            $paginacion['anterior'] = $pagina - 1;
        } else {
            $paginacion['primero'] = '';
            $paginacion['anterior'] = '';
        }

        if ($pagina < $total) {
            $paginacion['ultimo'] = $total;
            $paginacion['siguiente'] = $pagina + 1;
        } else {
            $paginacion['ultimo'] = '';
            $paginacion['siguiente'] = '';
        }

        $this->_paginacion = $paginacion;
        $this->_rangoPaginacion($paginacion);

        return $this->_datos;
    }

    private function _rangoPaginacion($limite = false) {
        if ($limite && is_numeric($limite)) {
            $limite = $limite;
        } else {
            $limite = 10;
        }

        $total_paginas = $this->_paginacion['total'];
        $pagina_seleccionada = $this->_paginacion['actual'];
        $rango = ceil($limite / 2);
        $paginas = array();

        $rango_derecho = $total_paginas - $pagina_seleccionada;

        if ($rango_derecho < $rango) {
            $resto = $rango - $rango_derecho;
        } else {
            $resto = 0;
        }

        $rango_izquierdo = $pagina_seleccionada - ($rango + $resto);

        for ($i = $pagina_seleccionada; $i > $rango_izquierdo; $i--) {
            if ($i == 0) {
                break;
            }

            $paginas[] = $i;
        }

        sort($paginas);

        if ($pagina_seleccionada < $rango) {
            $rango_derecho = $limite;
        } else {
            $rango_derecho = $pagina_seleccionada + $rango;
        }

        for ($i = $pagina_seleccionada + 1; $i <= $rango_derecho; $i++) {
            if ($i > $total_paginas) {
                break;
            }

            $paginas[] = $i;
        }

        $this->_paginacion['rango'] = $paginas;

        return $this->_paginacion;
    }

    public function getView($vista, $link = false) {
        $rutaView = ROOT . 'views' . DS . '_paginador' . DS . $vista . '.php';

        if ($link)
            $link = BASE_URL . $link . '/';

        if (is_readable($rutaView)) {
            ob_start();

            include $rutaView;

            $contenido = ob_get_contents();

            ob_end_clean();

            return $contenido;
        }

        throw new Exception('Error de paginacion');
    }

    public function getControlPaginaion() {
        return $this->_control_paginacion;
    }

    public function getNumeroPagina() {
        return $this->_numero_pagina;
    }

    public function LoadLenguaje() {
        
        $archivo="libs_paginador";
        $lang=  Cookie::lenguaje();
      
        $lenguaje_dir = ROOT . 'lenguaje' . DS . $lang . DS . $archivo . "_lang.php";
        if (is_readable($lenguaje_dir)) {
            include $lenguaje_dir;

            if (!isset($lenguaje) || empty($lenguaje)) {
                $lenguaje = array();
            }
            return $lenguaje;
        } else {
            throw new Exception('Error cargar lenguaje Libs Paginador');
        }
    }

}

?>
