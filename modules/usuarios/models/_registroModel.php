<?php

class registroModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function verificarUsuario($usuario)
    {
        try{
            $id = $this->_db->query(
                    "select Usu_IdUsuario, Usu_Codigo from usuario where Usu_Usuario = '$usuario'"
                    );
            return $id->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(registroModel)", "verificarUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        } 
    }
    
    public function verificarEmail($email)
    {
        $id = $this->_db->query(
                "select Usu_IdUsuario from usuario where Usu_Email = '$email'"
                );
        
        if($id->fetch()){
            return true;
        }
        
        return false;
    }
    
    public function registrarUsuario($nombre, $usuario, $password, $email)
    {
    	$random = rand(1782598471, 9999999999);
		
        $this->_db->prepare(
                "insert into usuario (Usu_Nombre,Usu_Usuario,Usu_Password,Usu_Email,Rol_IdRol,Usu_Fecha,Usu_Estado,Usu_Codigo) values " .
                "(:nombre, :usuario, :password, :email, 8, now(),1, :codigo)"
                )
                ->execute(array(
                    ':nombre' => $nombre,
                    ':usuario' => $usuario,
                    ':password' => Hash::getHash('sha1', $password, HASH_KEY),
                    ':email' => $email,
                    ':codigo' => $random
                ));
    }
    
    public function getUsuario($id, $codigo)
	{
		$usuario = $this->_db->query(
					"select * from usuario where Usu_IdUsuario = $id and Usu_Codigo = '$codigo'"
					);
					
		return $usuario->fetch();
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
