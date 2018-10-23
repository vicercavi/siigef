<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexModel
 *
 * @author JHON CHARLIE
 */
class indexModel extends Model {
    //put your code here
    public function __construct()
    {
        parent::__construct();
    }
    public function getPaginaTraducida($condicion,$Idi_IdIdioma)
    {
        $paginas = $this->_db->query(
            "SELECT 
                pa.Pag_IdPagina,
                pa.Pag_IdPrincipal,
                pa.Pag_TipoPagina,
                fn_TraducirContenido('pagina','Pag_Nombre',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Nombre) Pag_Nombre,
                fn_TraducirContenido('pagina','Pag_Descripcion',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Descripcion) Pag_Descripcion,
                fn_TraducirContenido('pagina','Pag_Contenido',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Contenido) Pag_Contenido,
                pa.Pag_Orden,
                pa.Pag_Url,
                pa.Pag_Estado,
                fn_devolverIdioma('pagina',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Idi_IdIdioma) Idi_IdIdioma

                FROM pagina pa $condicion"
        );
        return $paginas->fetch();
    }
}
