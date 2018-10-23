<?php

class indexModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }
    //MEnu Raiz
    public function getPadre($menu, $hijo)
    {
        $Idi_IdIdioma=Cookie::lenguaje();
        $menu = $this->_db->query(
            "SELECT 
                pa.Pag_IdPagina,
                pa.Pag_IdPrincipal,
                pa.Pag_TipoPagina,
                fn_TraducirContenido('pagina','Pag_Nombre',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Nombre) Pag_Nombre,
                pa.Pag_Orden,
                pa.Pag_Url,
                pa.Pag_Selectable,
                pa.Pag_Estado,
                fn_devolverIdioma('pagina',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Idi_IdIdioma) Idi_IdIdioma

                FROM pagina pa WHERE pa.Pag_Estado = 1 AND pa.Pag_IdPagina = $hijo AND pa.Pag_TipoPagina = $menu ");
        
        return $menu->fetchAll();        
    }    

    public function getMenusRaiz($menu, $hijo)
    {           
        $hijo = $this->getPadre($menu, $hijo);        
        for ($i = 0; $i < count($hijo); $i++) {
            if (!empty($hijo[$i]["Pag_IdPrincipal"])) {
                $Pag_IdPrincipal = $hijo[$i]["Pag_IdPrincipal"];               
                $temph = $this->getMenusRaiz($menu, $Pag_IdPrincipal);
                $hijo[$i]["padre"] = $temph ;
            }
        }
        return $hijo;       
    }

    //Fin Menu Raiz
    public function registrarBusqueda($iEsb_PalabraBuscada,$iEsb_Ip,$iEsb_TipoAcceso='principal') {
        try {                     
            $sql = "call s_i_estadistica_busqueda(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsb_PalabraBuscada, PDO::PARAM_STR);
            $result->bindParam(2, $iEsb_Ip, PDO::PARAM_STR);
            //  $result->bindParam(3, $Esd_CantidadBusqueda, PDO::PARAM_INT);
            $result->bindParam(3, $iEsb_TipoAcceso, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "registrarBusqueda", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }   
    public function registrarTraduccion($Cot_Tabla, $Cot_IdRegistro, $Cot_Columna, $Idi_IdIdioma, $Cot_Traduccion) {
        try {            
            $sql = "call s_i_contenido_traducido(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Cot_Tabla, PDO::PARAM_STR);
            $result->bindParam(2, $Cot_IdRegistro, PDO::PARAM_INT);
            $result->bindParam(3, $Cot_Columna, PDO::PARAM_STR);
            $result->bindParam(4, $Idi_IdIdioma, PDO::PARAM_STR);
            $result->bindParam(5, $Cot_Traduccion, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function actualizarTraduccion($Cot_IdContenidoTraducido, $Cot_Tabla, $Cot_IdRegistro, $Cot_Columna, $Idi_IdIdioma, $Cot_Traduccion) {
        try {
            $sql = "call s_u_contenido_traducido(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Cot_IdContenidoTraducido, PDO::PARAM_INT);
            $result->bindParam(2, $Cot_Tabla, PDO::PARAM_STR);
            $result->bindParam(3, $Cot_IdRegistro, PDO::PARAM_INT);
            $result->bindParam(4, $Cot_Columna, PDO::PARAM_STR);
            $result->bindParam(5, $Idi_IdIdioma, PDO::PARAM_STR);
            $result->bindParam(6, $Cot_Traduccion, PDO::PARAM_STR);
            $result->execute();
            return $result->rowCount();
        } catch (PDOException $exception) {          
            return $exception->getMessage();
        }
    }

    public function registrarPagina($iPag_IdPrincipal, $iPag_TipoPagina, $iPag_Sistema, $iPag_Nombre, $iPag_Descripcion, $iPag_Orden, $iPag_Contenido, $iPag_Url, $iPag_Selectable, $iPag_Estado, $iIdi_IdIdioma) {
        try {
            $sql = "call s_i_pagina(?,?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPag_IdPrincipal, PDO::PARAM_INT);
            $result->bindParam(2, $iPag_TipoPagina, PDO::PARAM_INT);
            $result->bindParam(3, $iPag_Sistema, PDO::PARAM_STR);
            $result->bindParam(4, $iPag_Nombre, PDO::PARAM_STR);
            $result->bindParam(5, $iPag_Descripcion, PDO::PARAM_STR);
            $result->bindParam(6, $iPag_Orden, PDO::PARAM_STR);
            $result->bindParam(7, $iPag_Contenido, PDO::PARAM_STR);
            $result->bindParam(8, $iPag_Url, PDO::PARAM_STR);
            $result->bindParam(9, $iPag_Selectable, PDO::PARAM_INT);
            $result->bindParam(10, $iPag_Estado, PDO::PARAM_INT);
            $result->bindParam(11, $iIdi_IdIdioma, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "registrarPagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function getBuscarPaginas($Pag_IdPrincipal,$Pag_TipoPagina,$Pag_Nombre,$Idi_IdIdioma) {
        if($Pag_TipoPagina==0){
            try {
                $sql = "call s_s_Buscar_Pagina(?,?,?,?)";
                $result = $this->_db->prepare($sql);
 		$Pag_Nombre=(empty($Pag_Nombre) ? NULL: $Pag_Nombre);
                $result->bindParam(1, $Pag_IdPrincipal, PDO::PARAM_INT);
                $result->bindParam(2, $Pag_TipoPagina, PDO::PARAM_INT);
                $result->bindParam(3, $Pag_Nombre, PDO::PARAM_STR);
                $result->bindParam(4, $Idi_IdIdioma, PDO::PARAM_STR);
                $result->execute();
                return $result->fetchAll();
            } catch (PDOException $exception) {
                $this->registrarBitacora("arquitectura(indexModel)", "getBuscarPaginas_0", "Error Model", $exception);
                return $exception->getTraceAsString();
            }
        }else{            
            try {
                $sql = "call s_s_Buscar_Tipo_Pagina(?,?,?,?)";
                $result = $this->_db->prepare($sql);
                $result->bindParam(1, $Pag_IdPrincipal, PDO::PARAM_INT);
                $result->bindParam(2, $Pag_TipoPagina, PDO::PARAM_INT);
                $result->bindParam(3, empty($Pag_Nombre) ? NULL: $Pag_Nombre, PDO::PARAM_STR);
                $result->bindParam(4, $Idi_IdIdioma, PDO::PARAM_STR);
                $result->execute();
                return $result->fetchAll();
            } catch (PDOException $exception) {
                $this->registrarBitacora("arquitectura(indexModel)", "getBuscarPaginas", "Error Model", $exception);
                return $exception->getTraceAsString();
            }
        }
    }

    public function editarTraduccion($Pag_Nombre, $Pag_Descripcion, $Pag_IdPagina, $Idi_IdIdioma) {

        $ContTradNombre = $this->buscarCampoTraducido('pagina', $Pag_IdPagina, 'Pag_Nombre', $Idi_IdIdioma);
        $ContTradDescripcion = $this->buscarCampoTraducido('pagina', $Pag_IdPagina, 'Pag_Descripcion', $Idi_IdIdioma);

        $idContTradNombre = $ContTradNombre['Cot_IdContenidoTraducido'];
        $idContTradDescripcion = $ContTradDescripcion['Cot_IdContenidoTraducido'];

        if (isset($idContTradNombre)) {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Pag_Nombre' WHERE Cot_IdContenidoTraducido = $idContTradNombre"
            );
        } else {

            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'pagina', :Cot_IdRegistro, 'Pag_Nombre' , :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Pag_IdPagina,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Pag_Nombre
            ));
        }

        if (isset($idContTradDescripcion)) {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Pag_Descripcion' WHERE Cot_IdContenidoTraducido = $idContTradDescripcion"
            );
        } else {

            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'pagina', :Cot_IdRegistro, 'Pag_Descripcion' , :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Pag_IdPagina,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Pag_Descripcion
            ));
        }
    }

    public function editarContenidoTraduccion($Contenido, $Pag_IdPagina, $Idi_IdIdioma) {
        $ContTradContenido = $this->buscarCampoTraducido('pagina', $Pag_IdPagina, 'Pag_Contenido', $Idi_IdIdioma);

        $idContTradContenido = $ContTradContenido['Cot_IdContenidoTraducido'];

        if (isset($idContTradContenido)) {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Contenido' WHERE Cot_IdContenidoTraducido = $idContTradContenido"
            );
        } else {

            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'pagina', :Cot_IdRegistro, 'Pag_Contenido' , :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Pag_IdPagina,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Contenido
            ));
        }
    }

    public function buscarCampoTraducido($tabla, $Pag_IdPagina, $columna, $Idi_IdIdioma) {
        try{
            $post = $this->_db->query(
                    "SELECT * FROM contenido_traducido WHERE Cot_Tabla = '$tabla' AND Cot_IdRegistro =  $Pag_IdPagina AND  Cot_Columna = '$columna' AND Idi_IdIdioma= '$Idi_IdIdioma'");
            return $post->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "buscarCampoTraducido", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function verificarNombrePagina($Pag_IdPrincipal, $Pag_Nombre, $Pag_TipoPagina, $Pag_IdPagina = false) {
        try{            
            if ($Pag_IdPagina) {
                $post = $this->_db->query(
                        "SELECT Pag_IdPagina, Pag_Nombre FROM pagina WHERE Pag_IdPrincipal = $Pag_IdPrincipal AND Pag_TipoPagina = $Pag_TipoPagina AND Pag_Nombre = '$Pag_Nombre' AND Pag_IdPagina != $Pag_IdPagina ");
            } else {
                $post = $this->_db->query(
                        "SELECT Pag_IdPagina, Pag_Nombre FROM pagina WHERE Pag_IdPrincipal = $Pag_IdPrincipal AND Pag_TipoPagina = $Pag_TipoPagina AND Pag_Nombre = '$Pag_Nombre' ");
            }
        return $post->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "verificarNombrePagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function verificarOrdenPagina($Pag_IdPrincipal, $Pag_Orden, $Pag_TipoPagina, $Pag_IdPagina = false) {
        try{
            if ($Pag_IdPagina) {
                $post = $this->_db->query(
                        "SELECT Pag_IdPagina, Pag_Nombre FROM pagina WHERE Pag_IdPrincipal = $Pag_IdPrincipal AND Pag_TipoPagina = $Pag_TipoPagina AND Pag_Orden = $Pag_Orden AND Pag_IdPagina != $Pag_IdPagina ");
            } else {
                $post = $this->_db->query(
                        "SELECT Pag_IdPagina, Pag_Nombre FROM pagina WHERE Pag_IdPrincipal = $Pag_IdPrincipal AND Pag_TipoPagina = $Pag_TipoPagina AND Pag_Orden = $Pag_Orden ");
            }
            return $post->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "verificarOrdenPagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function verificarIdioma($Pag_IdPagina, $Idi_IdIdioma) {
        try{
            $post = $this->_db->query(
                    "SELECT Pag_IdPagina, Pag_Nombre FROM pagina WHERE Pag_IdPagina = $Pag_IdPagina AND Idi_IdIdioma = '$Idi_IdIdioma' ");
            return $post->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "verificarIdioma", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getPaginas($condicion = '', $Idi_IdIdioma) {
        try{            
            $paginas = $this->_db->query(
                   "SELECT 
                   pa.Pag_IdPagina,
                   pa.Pag_IdPrincipal,
                   pa.Pag_TipoPagina,
                   pa.Pag_Sistema,		   
                   fn_TraducirContenido('pagina','Pag_Nombre',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Nombre) Pag_Nombre,
                   fn_TraducirContenido('pagina','Pag_Descripcion',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Descripcion) Pag_Descripcion,
                   fn_TraducirContenido('pagina','Pag_Contenido',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Contenido) Pag_Contenido,
                   pa.Pag_Orden,
                   pa.Pag_Url,
                   pa.Pag_Selectable,
                   pa.Pag_Estado,
                   fn_devolverIdioma('pagina',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Idi_IdIdioma) Idi_IdIdioma

                   FROM pagina pa $condicion"
           );
           return $paginas->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "getPaginas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

/*Avance Buscador */
/*
    public function getPaginas($condicion = '', $Idi_IdIdioma, $palabraBuscada) {
        try{            
            $paginas = $this->_db->query(
                   "SELECT 
                   pa.Pag_IdPagina,
                   pa.Pag_IdPrincipal,
                   pa.Pag_TipoPagina,
                   pa.Pag_Sistema,
		   MATCH(
                   fn_TraducirContenido('pagina','Pag_Nombre',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Nombre) Pag_Nombre,
                   fn_TraducirContenido('pagina','Pag_Descripcion',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Descripcion) Pag_Descripcion,
                   fn_TraducirContenido('pagina','Pag_Contenido',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Contenido) Pag_Contenido) AGAINST '$palabraBuscada',
                   pa.Pag_Orden,
                   pa.Pag_Url,
                   pa.Pag_Selectable,
                   pa.Pag_Estado,
                   fn_devolverIdioma('pagina',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Idi_IdIdioma) Idi_IdIdioma

                   FROM pagina pa $condicion"
           );
           return $paginas->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "getPaginas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

*/

    public function getPagina($condicion = '') {
        try{
            $pagina = $this->_db->query(
                    "select * from pagina  $condicion"
            );
            return $pagina->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "getPagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getPaginaTraducida($condicion, $Idi_IdIdioma) {
        try{
            $paginas = $this->_db->query(
                    "SELECT 
                    pa.Pag_IdPagina,
                    pa.Pag_IdPrincipal,
                    pa.Pag_TipoPagina,
                    pa.Pag_Sistema,
                    fn_TraducirContenido('pagina','Pag_Nombre',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Nombre) Pag_Nombre,
                    fn_TraducirContenido('pagina','Pag_Descripcion',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Descripcion) Pag_Descripcion,
                    pa.Pag_Orden,
                    fn_TraducirContenido('pagina','Pag_Contenido',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Contenido) Pag_Contenido,
                    pa.Pag_Url,
                    pa.Pag_Selectable,
                    pa.Pag_Estado,
                    fn_devolverIdioma('pagina',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Idi_IdIdioma) Idi_IdIdioma

                    FROM pagina pa $condicion"
            );
            return $paginas->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "getPaginas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getIdiomas() {
        try{
            $idiomas = $this->_db->query(
                    "select * from idioma where Idi_Estado = 1"
            );
            return $idiomas->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "getPaginas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function cambiarEstadoPagina($idpagina, $estado) {
        try{
            if ($estado == 0) {
                $paginas = $this->_db->query(
                        "UPDATE pagina SET Pag_Estado = 1 where Pag_IdPagina = $idpagina"
                );
            }
            if ($estado == 1) {
                $paginas = $this->_db->query(
                        "UPDATE pagina SET Pag_Estado = 0 where Pag_IdPagina = $idpagina"
                );
            }
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "cambiarEstadoPagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function editarPagina($Pag_Nombre, $Pag_Descripcion, $Pag_Orden, $Pag_Url, $Pag_TipoPagina,$Pag_Selectable, $Pag_IdPagina) {
        try{
            $paginas = $this->_db->query(
                "UPDATE pagina SET Pag_TipoPagina = $Pag_TipoPagina, Pag_Nombre = '$Pag_Nombre', Pag_Descripcion = '$Pag_Descripcion',
                Pag_Orden = $Pag_Orden, Pag_Url = '$Pag_Url', Pag_Selectable = $Pag_Selectable WHERE Pag_IdPagina = $Pag_IdPagina"
            );
            return $paginas->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "cambiarEstadoPagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function editarContenidoPagina($contenido, $Pag_IdPagina) {
        try{
            $paginas = $this->_db->query(
                    "UPDATE pagina SET Pag_Contenido = '$contenido' where Pag_IdPagina = $Pag_IdPagina"
            );
            return $paginas->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("arquitectura(indexModel)", "cambiarEstadoPagina", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}
