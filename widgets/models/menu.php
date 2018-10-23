<?php

class menuModelWidget extends Model
{
    public function __construct(){
        parent::__construct();
    }
    public function getPrincipal($menu, $padre)
    {
        $Idi_IdIdioma=Cookie::lenguaje();
        $menu = $this->_db->query(
            "SELECT 
                pa.Pag_IdPagina,
                pa.Pag_IdPrincipal,
                pa.Pag_TipoPagina,
                fn_TraducirContenido('pagina','Pag_Nombre',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Nombre) Pag_Nombre,
                fn_TraducirContenido('pagina','Pag_Descripcion',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Descripcion) Pag_Descripcion,
                fn_TraducirContenido('pagina','Pag_Contenido',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Pag_Contenido) Pag_Contenido,
                pa.Pag_Orden,
                pa.Pag_Url,
                pa.Pag_Selectable,
                pa.Pag_Estado,
                fn_devolverIdioma('pagina',pa.Pag_IdPagina,'$Idi_IdIdioma',pa.Idi_IdIdioma) Idi_IdIdioma

                FROM pagina pa WHERE pa.Pag_Estado = 1 AND pa.Pag_IdPrincipal = $padre AND pa.Pag_TipoPagina = $menu ");
        
        return $menu->fetchAll();        
    }    

    public function getMenus($menu, $padre)
    {           
        $padre = $this->getPrincipal($menu, $padre);        
        for ($i = 0; $i < count($padre); $i++) {
            if (!empty($padre[$i]["Pag_IdPagina"])) {
                $idpagina = $padre[$i]["Pag_IdPagina"];               
                $temph = $this->getMenus($menu, $idpagina);
                $padre[$i]["hijo"] = $temph ;
            }
        }
        return $padre;       
    }

    public function getFooter($menu, $padre, $idPagina = false)
    {
        $Idi_IdIdioma=Cookie::lenguaje();
        if($idPagina){
            $idPag = "AND pa.Pag_IdPagina = $idPagina";
        }  else {
            $idPag = "";
        }
        $menu = $this->_db->query(
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

                FROM pagina pa WHERE pa.Pag_Estado = 1 AND pa.Pag_IdPrincipal = $padre AND pa.Pag_TipoPagina = $menu $idPag");
        
        return $menu->fetchAll();        
    }
    
    private function filter($menu)
    {
    // obtenemos la instancia del registro
    $reg = Registry::getInstancia();

    // arreglo que almacena los items filtrados
    $filtro = array();
    
    foreach ($menu as $item) {
        // verificamos si está presente la clave "permiso" en el arreglo del item del menú
        if(isset($item['permiso'])){
            // si el usuario no tiene el permiso habilitado se salta en el bucle
            if( ! $reg->_acl->permiso($item['permiso'])){           
                continue;                
            }
        }
        
        // verificamos si está presente la clave "sub_menu" en el arreglo del item del menú
        if(isset($item['sub_menu']) && sizeof($item['sub_menu']) > 0){
            // pasamos el filtro a los sub-enlaces del item
            $sub_links = array_map(function($item) use ($reg){
                if(isset($item['permiso'])){
                    if( ! $reg->_acl->permiso($item['permiso'])){
                        return false;
                    }
                }

                return $item;
            }, $item['sub_menu']);

            $item['sub_menu'] = array_filter($sub_links);
        }

        // asignamos el item
        $filtro[] = $item;
    }

    return $filtro;
}
}

?>