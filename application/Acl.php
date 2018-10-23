<?php

class ACL
{
    private $_registry;
    private $_db;
    private $_id;
    private $_role;
    private $_permisos;
    
    public function __construct($id = false)
    {
        if($id)
        {
            $this->_id = (int) $id;
        }
        else
        {
            if(Session::get('id_usuario'))
            {
                $this->_id = Session::get('id_usuario');
            }
            else
            {
                $this->_id = 0;
            }
        }
                
        $this->_registry = Registry::getInstancia();
        $this->_db = $this->_registry->_db;
        $this->_role = $this->getRole();
        $this->_permisos = $this->getPermisosRole();
        $this->compilarAcl();
    }
    
    public function compilarAcl()
    {
        $this->_permisos = array_merge($this->_permisos, $this->getPermisosUsuario());
    }
    
    public function getRole()
    { 
        $role = $this->_db->query("select Rol_IdRol from usuario" .
                                " where Usu_IdUsuario = {$this->_id}");       
                
        $role = $role->fetch();
        if($role['Rol_IdRol'])
        {          
            return $role['Rol_IdRol'];
        }
        else 
            return 0;
                
    }
    
    public function getPermisosRoleId()
    {
        $ids = $this->_db->query("select Per_IdPermiso from permisos_rol " .
                "where Rol_IdRol = {$this->_role}");
                
        $ids = $ids->fetchAll(PDO::FETCH_ASSOC);
        
        $id = array();
        
        for($i = 0; $i < count($ids); $i++){
            $id[] = $ids[$i]['Per_IdPermiso'];
        }
        
        return $id;
    }
    
    public function getPermisosRole()
    {     
        $permisos = $this->_db->query("select * from permisos_rol where Rol_IdRol = {$this->_role}"
                );   
        $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
          
        $data = array();
        
        for($i = 0; $i < count($permisos); $i++)
        {
            $key = $this->getPermisoKey($permisos[$i]['Per_IdPermiso']);
            if($key == ''){continue;}
            
            if($permisos[$i]['Rol_Valor'] == 1)
            {
                $v = true;
            }
            else
            {
                $v = false;
            }
            
            $data[$key] = array(
                'key' => $key,
                'permiso' => $this->getPermisoNombre($permisos[$i]['Per_IdPermiso']),
                'valor' => $v,
                'heredado' => true,
                'id' => $permisos[$i]['Per_IdPermiso']
            );
        }
        
        return $data;
    }
    
    public function getPermisoKey($permisoID)
    {
        $permisoID = (int) $permisoID;
        
        $key = $this->_db->query(
                "select Per_Ckey as `key` from permisos " .
                "where Per_IdPermiso = {$permisoID}"
                );
                
        $key = $key->fetch();
        return $key['key'];
    }
    
    public function getPermisoNombre($permisoID)
    {
        $permisoID = (int) $permisoID;
        
        $key = $this->_db->query(
                "select Per_Permiso from permisos " .
                "where Per_IdPermiso = {$permisoID}"
                );
                
        $key = $key->fetch();
        return $key['Per_Permiso'];
    }
    
    public function getPermisosUsuario()
    {
        $ids = $this->getPermisosRoleId();
        
        if(count($ids))
        {
            $permisos = $this->_db->query(
                    "select * from permisos_usuario " .
                    "where Usu_IdUsuario = {$this->_id} " .
                    "and Per_IdPermiso in (" . implode(",", $ids) . ")"
                    );

            $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $permisos = array();
        }
        
        $data = array();
        
        for($i = 0; $i < count($permisos); $i++)
        {
            $key = $this->getPermisoKey($permisos[$i]['Per_IdPermiso']);
            if($key == '')
            {
                continue;
            }
            
            if($permisos[$i]['Usu_Valor'] == 1)
            {
                $v = true;
            }
            else
            {
                $v = false;
            }
            
            $data[$key] = array(
                'key' => $key,
                'permiso' => $this->getPermisoNombre($permisos[$i]['Per_IdPermiso']),
                'valor' => $v,
                'heredado' => false,
                'id' => $permisos[$i]['Per_IdPermiso']
            );
        }
        
        return $data;
    }
    
    public function getPermisos()
    {
        if(isset($this->_permisos) && count($this->_permisos))
            return $this->_permisos;
    }
    
    public function permiso($key)
    {
        if(array_key_exists($key, $this->_permisos)){
            if($this->_permisos[$key]['valor'] == true || $this->_permisos[$key]['valor'] == 1)
            {
                return true;
            }
        }
        
        return false;
    }
    
    public function acceso($key)
    {   
        if($this->permiso($key))
        {
            Session::tiempo();
            return;
        }
        $url=str_replace("/","*",$this->_registry->_request->getUrl());
        //$url=$_SERVER['HTTP_REFERER'];    
//        if(isset($url)&&!empty($url))
//        {
//           $url="/"+$url;
//        }
//        else
//        {
//          $url="";  
//        }
        if(Session::get('autenticado'))
        {
           header("location:" . BASE_URL . "error/access/5050/$url");
            return;
        }else{
            header("location:" . BASE_URL . "usuarios/login/index/$url");
        }
        
        exit;
    }
    public function autenticado()
    {
        if(Session::get('autenticado'))
        {
            Session::tiempo();
            return;
        }
        $url=str_replace("/","*",$this->_registry->_request->getUrl());
        //$url=$_SERVER['HTTP_REFERER'];
        //if(isset($url)&&!empty($url))
        //{
          //  $url="/"+$url;
        //}
        //else
        //{
         // $url="";  
        //}
        
        header("location:" . BASE_URL . "usuarios/login/index/$url");
        exit;
    }
}

?>
