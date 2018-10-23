<?php

class loginModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getUsuario($usuario, $password)
    {
        try{
            $datos = $this->_db->query(
                    "select * from usuario " .
                    "where Usu_Usuario = '$usuario' " .
                    "and Usu_Password = '" . Hash::getHash('sha1', $password, HASH_KEY) ."'"
                    );
            return $datos->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("usuario(loginModel)", "getUsuario", "Error Model", $exception);
            return $exception->getTraceAsString();
        } 
    }
}

?>
