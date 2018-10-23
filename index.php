<?php

date_default_timezone_set('America/Sao_Paulo');//Definir Zona Horaria, Brasil. 

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);

try{
    require_once APP_PATH . 'Autoload.php';
    require_once APP_PATH . 'Config.php';
    
    Session::init();   
    //Registry->Se utiliza para guardar instancia de clases que utilizan en toda
    //la aplicacion, utiliza el patron Singleton.
    $registry = Registry::getInstancia();
    $registry->_request = new Request();
   
    $registry->_db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHAR);
    $registry->_acl = new ACL();

    Bootstrap::run($registry->_request);
}
catch(Exception $e){
    echo $e->getMessage();
}


?>