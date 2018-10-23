<?php

class perfilModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }    
    public function getUsuarioPass($idusuario, $password)
    {
        try{
            $datos = $this->_db->query(
                    "select * from usuario " .
                    "where Usu_IdUsuario = $idusuario " .
                    "and Usu_Password = '" . Hash::getHash('sha1', $password, HASH_KEY) ."'"
                    );
            return $datos->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(loginModel)", "getUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        } 
    }
    public function getUsuarios($condicion = '')
    {
        try{
            $usuarios = $this->_db->query(
                "select u.*,r.Rol_role from usuario u, rol r ".
                "where u.Rol_IdRol = r.Rol_IdRol $condicion"
            );
            if(!$condicion)
            {
                return $usuarios->fetchAll();
            }  else {
                return $usuarios->fetch();
            }
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "getUsuarios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    public function getUsuario($usuarioID)
    {
        try{
            $usuarios = $this->_db->query(
                "select u.*,r.Rol_role from usuario u, rol r ".
                "where u.Rol_IdRol = r.Rol_IdRol and u.Usu_IdUsuario = $usuarioID"
            );
            return $usuarios->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "getUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function editarUsuarioPerfil($iUsu_Nombre, $iUsu_Apellidos, $iUsu_DocumentoIdentidad, $iUsu_Direccion, $iUsu_Telefono,
        	$iUsu_InstitucionLaboral, $iUsu_Cargo, $iUsu_Usuario, $iUsu_Email, $iUsu_IdUsuario
           )
    {
            $iUsu_Password = Hash::getHash('sha1', $iUsu_Password, HASH_KEY);
            try {            
                $sql = "call s_u_usuarioPerfil(?,?,?,?,?,?,?,?,?,?)";
                $result = $this->_db->prepare($sql);
                $result->bindParam(1, $iUsu_Nombre, PDO::PARAM_STR);
                $result->bindParam(2, $iUsu_Apellidos, PDO::PARAM_STR);
                $result->bindParam(3, $iUsu_DocumentoIdentidad, PDO::PARAM_STR);
                $result->bindParam(4, $iUsu_Direccion, PDO::PARAM_STR);
                $result->bindParam(5, $iUsu_Telefono, PDO::PARAM_STR);
                $result->bindParam(6, $iUsu_InstitucionLaboral, PDO::PARAM_STR);
                $result->bindParam(7, $iUsu_Cargo, PDO::PARAM_STR);
                $result->bindParam(8, $iUsu_Usuario, PDO::PARAM_STR);
                $result->bindParam(9, $iUsu_Email, PDO::PARAM_STR);
                $result->bindParam(10, $iUsu_IdUsuario, PDO::PARAM_INT);

                $result->execute();
                return $result->rowCount(PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                $this->registrarBitacora("usuario(indexModel)", "editarUsuario(1)", "Error Model", $exception);
                return $exception->getTraceAsString();
            }         
        
    }   
}

?>
