<?php

/*
 * -------------------------------------
 * www.dlancedu.com | Jaisiel Delance
 * framework mvc basico
 * Config.php
 * -------------------------------------
 */


define('BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].'/siigef/');
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'backend');
define('LAYOUT_FRONTEND', 'frontend');
define('ROOT_ARCHIVO_FISICO',$_SERVER['DOCUMENT_ROOT']."/siigef/archivosFisicos/");
define('URL_ARCHIVO_FISICO',BASE_URL."archivosFisicos/");
define('LENGUAJE', 'es');

define('APP_NAME', 'SII - OTCA');
define('APP_SLOGAN', 'Sistema Integrado de Informacion del Proyecto Manejo integrado y sostenible de los recursos hídricos transfronterizos en la cuenca del Amazonas');
define('APP_COMPANY', 'www.iiap.org.pe');
define('COOKIE_TIME', 60*(1*24));//minutos()
define('SESSION_TIME', 10000000000000000);
define('HASH_KEY', '4f6a6d832be79');

define('DB_HOST', 'localhost');
define('DB_USER', 'siibd');
define('DB_PASS', 'pric');
define('DB_NAME', 'siigef');
define('DB_CHAR', 'utf8');

?>
