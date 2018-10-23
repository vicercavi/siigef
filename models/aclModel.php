<?php

class aclModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getRole($roleID)
    {
        $roleID = (int) $roleID;
        
        $role = $this->_db->query("SELECT * FROM rol WHERE Rol_IdRol = {$roleID}");
        return $role->fetch();
    }
    
    public function getRoles()
    {
        $roles = $this->_db->query("SELECT * FROM rol");
        
        return $roles->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPermisosRole($roleID)
    {
        $data = array();
        
        $permisos = $this->_db->query(
                "SELECT * FROM permisos_rol WHERE Rol_IdRol = {$roleID}"
                );
                
        $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
        
        for($i = 0; $i < count($permisos); $i++){
            $key = $this->getPermisoKey($permisos[$i]['Per_IdPermiso']);
            
            if($key == ''){continue;}
            if($permisos[$i]['Rol_Valor'] == 1){
                $v = true;
            }
            else{
                $v = false;
            }
            
            $data[$key] = array(
                'key' => $key,
                'valor' => $v,
                'nombre' => $this->getPermisoNombre($permisos[$i]['Per_IdPermiso']),
                'id' => $permisos[$i]['Per_IdPermiso']
            );
        }
        
        $todos = $this->getPermisosAll();
        $data = array_merge($todos, $data);
        
        return $data;
    }
    
    public function getPermisoKey($permisoID)
    {
        $permisoID = (int) $permisoID;
        
        $key = $this->_db->query(
                "SELECT Per_Ckey as 'key' FROM permisos WHERE Per_IdPermiso = $permisoID"
                );
        
        $key = $key->fetch();
        return $key['key'];
    }
    
    public function getPermisoNombre($permisoID)
    {
        $permisoID = (int) $permisoID;
        
        $key = $this->_db->query(
                "SELECT Per_Permiso FROM permisos WHERE Per_IdPermiso = $permisoID"
                );
        
        $key = $key->fetch();
        return $key['Per_Permiso'];
    }
    
    public function getPermisosAll()
    {
        $permisos = $this->_db->query(
                "SELECT * FROM permisos"
                );
                
        $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
        
        for($i = 0; $i < count($permisos); $i++){
            $data[$permisos[$i]['Per_Ckey']] = array(
                'key' => $permisos[$i]['Per_Ckey'],
                'valor' => 'x',
                'nombre' => $permisos[$i]['Per_Permiso'],
                'id' => $permisos[$i]['Per_IdPermiso']
            );
        }
        
        return $data;
    }
    
    public function insertarRole($role)
    {
        $this->_db->query("INSERT INTO rol VALUES(null, '{$role}', null)");
    }
    
    public function getPermisos()
    {
        $permisos = $this->_db->query("SELECT * FROM permisos");
        
        return $permisos->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPermisosUsuario()
    {
        $permisos = $this->_db->query("SELECT * FROM permisos_usuario");
        
        return $permisos->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function eliminarPermisoRole($roleID, $permisoID)
    {
        $this->_db->query(
                "DELETE FROM permisos_rol " . 
                "WHERE Per_IdPermiso = {$permisoID} " .
                "AND Rol_IdRol = {$roleID} "
               
                );
    }

    public function editarPermisoRole($roleID, $permisoID, $valor)
    {
        $this->_db->query(
                "replace into permisos_rol set Rol_IdRol = {$roleID}, Per_IdPermiso = {$permisoID}, Rol_Valor = '{$valor}'"
                );
    }

    public function insertarPermiso($permiso, $llave)
    {
        $this->_db->query(
                "INSERT INTO permisos VALUES" .
                "(null, '{$permiso}', '{$llave}',null)"
                );
    }
}

?>
