<?php

class indexModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuarios($condicion = '')
    {
        try{
            $usuarios = $this->_db->query(
                "select u.*,r.Rol_role from usuario u, rol r ".
                "where u.Rol_IdRol = r.Rol_IdRol $condicion"
            );           
            return $usuarios->fetchAll();            
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
    public function eliminarUsuario($Usu_IdUsuario){
        try{
            $usu = $this->_db->query(
                "delete from usuario where Usu_IdUsuario = $Usu_IdUsuario "
            );
            return $usu->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "eliminarUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getRoles()
    {
        try{
            $roles = $this->_db->query(
                "SELECT * FROM rol WHERE Rol_Estado = 1" );
            return $roles->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "getRoles", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function getPermisosUsuario($usuarioID)
    {
        $acl = new  ACL($usuarioID);
        return $acl->getPermisos();
    }
    
    public function getPermisosRole($usuarioID)
    {
        $acl = new ACL($usuarioID);
        return $acl->getPermisosRole();
    }
    
    public function editarRolUsuario($usuarioID, $rolID)
    {
        try{
            $usu = $this->_db->query(
                "UPDATE usuario SET Rol_IdRol = $rolID 
                WHERE Usu_IdUsuario = $usuarioID"              
            );
            return $usu->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "editarRolUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function eliminarPermiso($usuarioID, $permisoID)
    {
        try{
            $per = $this->_db->query(
                "delete from permisos_usuario where Usu_IdUsuario = $usuarioID and Per_IdPermiso = $permisoID"
            );
            return $per->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "eliminarPermiso", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function editarPermiso($usuarioID, $permisoID, $valor)
    {
        try{
            $per = $this->_db->query(
                "replace into permisos_usuario set Usu_IdUsuario = $usuarioID , Per_IdPermiso = $permisoID, Usu_Valor ='$valor'"
            );
            return $per->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "editarPermiso", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function verificarUsuario($usuario)
    {
        try{
            $id = $this->_db->query(
                    "select Usu_IdUsuario, Usu_Codigo from usuario where Usu_Usuario = '$usuario'"
                    );
            return $id->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "verificarUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function verificarEmail($email)
    {
        try{
            $id = $this->_db->query(
                    "select Usu_IdUsuario, Usu_Codigo from usuario where Usu_Email = '$email'"
                    );        
            return $id->fetch(PDO::FETCH_ASSOC);            
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "verificarUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function registrarUsuario($iUsu_Nombre, $iUsu_Apellidos, $iUsu_DocumentoIdentidad, $iUsu_Direccion, $iUsu_Telefono,
        	$iUsu_InstitucionLaboral, $iUsu_Cargo, $iUsu_Usuario, $iUsu_Password, $iUsu_Email, $iRol_IdRol, $iUsu_Estado,
        	$iUsu_Codigo
           )
    {              
        $iUsu_Password = Hash::getHash('sha1', $iUsu_Password, HASH_KEY);
        try {            
            $sql = "call s_i_usuario(?,?,?,?,?,?,?,?,?,?,?,now(),?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iUsu_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iUsu_Apellidos, PDO::PARAM_STR);
            $result->bindParam(3, $iUsu_DocumentoIdentidad, PDO::PARAM_STR);
            $result->bindParam(4, $iUsu_Direccion, PDO::PARAM_STR);
            $result->bindParam(5, $iUsu_Telefono, PDO::PARAM_STR);
            $result->bindParam(6, $iUsu_InstitucionLaboral, PDO::PARAM_STR);
            $result->bindParam(7, $iUsu_Cargo, PDO::PARAM_STR);
            $result->bindParam(8, $iUsu_Usuario, PDO::PARAM_STR);
            $result->bindParam(9, $iUsu_Password, PDO::PARAM_STR);
            $result->bindParam(10, $iUsu_Email, PDO::PARAM_STR);
            $result->bindParam(11, $iRol_IdRol, PDO::PARAM_INT);
//            $result->bindParam(12, $iUsu_Fecha, PDO::PARAM_STR);
            $result->bindParam(12, $iUsu_Estado, PDO::PARAM_INT);
            $result->bindParam(13, $iUsu_Codigo, PDO::PARAM_STR);
           
            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "registrarUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function editarUsuario($iUsu_Nombre, $iUsu_Apellidos, $iUsu_DocumentoIdentidad, $iUsu_Direccion, $iUsu_Telefono,
        	$iUsu_InstitucionLaboral, $iUsu_Cargo, $iUsu_Email, $iRol_IdRol, $iUsu_IdUsuario
           )
    {
        try {            
            $sql = "call s_u_usuario(?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iUsu_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iUsu_Apellidos, PDO::PARAM_STR);
            $result->bindParam(3, $iUsu_DocumentoIdentidad, PDO::PARAM_STR);
            $result->bindParam(4, $iUsu_Direccion, PDO::PARAM_STR); 
            $result->bindParam(5, $iUsu_Telefono, PDO::PARAM_STR);
            $result->bindParam(6, $iUsu_InstitucionLaboral, PDO::PARAM_STR);
            $result->bindParam(7, $iUsu_Cargo, PDO::PARAM_STR);
//            $result->bindParam(8, $iUsu_Usuario, PDO::PARAM_STR);
//            $result->bindParam(9, $iUsu_Password, PDO::PARAM_STR);
            $result->bindParam(8, $iUsu_Email, PDO::PARAM_STR);
            $result->bindParam(9, $iRol_IdRol, PDO::PARAM_INT);
//            $result->bindParam(12, $iUsu_Fecha, PDO::PARAM_STR);
//            $result->bindParam(12, $iUsu_Estado, PDO::PARAM_INT);
            //$result->bindParam(13, $iUsu_Codigo, PDO::PARAM_STR);
            $result->bindParam(10, $iUsu_IdUsuario, PDO::PARAM_INT);
            
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "editarUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        }         
    }
    
    public function editarUsuarioClave($Usu_Password, $Usu_IdUsuario)
    {
        $Usu_Password = Hash::getHash('sha1', $Usu_Password, HASH_KEY);
        try {
            $result = $this->_db->query(
                            "update usuario set Usu_Password = '$Usu_Password' " .
                            "where Usu_IdUsuario = $Usu_IdUsuario "
                            );
            return $result->rowCount();
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(indexModel)", "editarUsuarioClave", "Error Model", $exception);
            return $exception->getTraceAsString();
        }            
    }
   
    public function cambiarEstadoUsuario($idUsuario, $estado)
    {
        if($estado==0)
        {
            $usuarios = $this->_db->query(
            "UPDATE usuario SET Usu_Estado = 1 where Usu_IdUsuario = $idUsuario"
            );
        }
        if($estado==1)
        {
            $usuarios = $this->_db->query(
            "UPDATE usuario SET Usu_Estado = 0 where Usu_IdUsuario = $idUsuario"
            );
        }
        
        return $usuarios->rowCount(PDO::FETCH_ASSOC);
    }
    
    public function getUsuario1($id, $codigo)
    {
        $usuario = $this->_db->query(
                "select * from usuario where Usu_IdUsuario = $id and Usu_Codigo = '$codigo'"
                );
        return $usuario->fetch();
    }
    
    public function insertarRol($iRol_role, $iIdi_IdIdioma="", $iRol_Estado=1)
    {
        try {            
            $sql = "call s_i_rol(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRol_role, PDO::PARAM_STR);
            $result->bindParam(2, empty($iIdi_IdIdioma) ? null : $iIdi_IdIdioma, PDO::PARAM_NULL | PDO::PARAM_STR);
            $result->bindParam(3, $iRol_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function activarUsuario($id, $codigo)
    {
            $this->_db->query(
                            "update usuario set Usu_Estado = 1 " .
                            "where Usu_IdUsuario = $id and Usu_Codigo = '$codigo'"
                            );
    }
}

?>
