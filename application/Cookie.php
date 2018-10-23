<?php


class Cookie
{
    public static function init()
    {
      
       // header('Cache-control: private'); // IE 6 FIX
    }
    
    public static function destroy($clave = false)
    {
        if($clave)
        {
            if(is_array($clave))
            {
                for($i = 0; $i < count($clave); $i++)
                {
                    if(isset($_COOKIE[$clave[$i]])){
                        setcookie($clave[$i], '', time() - 3600);
                    }
                }
            }
            else
            {
                if(isset($_COOKIE[$clave]))
                {
                    setcookie($clave, '', time() - 3600);
                }
            }
        }        
    }
    
    public static function set($clave, $valor)
    {       
        if(!empty($clave))
        {          
          setcookie($clave, $valor, time() + (COOKIE_TIME)*60,"/");        
        }
    }
    
    public static function get($clave)
    {
        if(isset($_COOKIE[$clave]))
            return $_COOKIE[$clave];       
    }
    
    public static function lenguaje()
    {
        $idioma=LENGUAJE;

        if(Session::get('langsiigef'))
        {           
            $idioma=Session::get('langsiigef');                      
           
        }
        else  if(Cookie::get('langsiigef'))
        {
            $idioma=Cookie::get('langsiigef');    
           
        }
        else{         
      
            if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            {
                $idioma = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                $idioma = substr($idioma, 0, 2);
                Session::set('langsiigef', $idioma);
                Cookie::set('langsiigef',$idioma);
            }else{
                $idioma=true;
            }
        }
        return $idioma;       
    }   
     public static function antlenguaje()
    {
        $idioma=LENGUAJE;

        if(Session::get('antlangsiigef'))
        {           
            $idioma=Session::get('antlangsiigef');                      
           
        }
        else  if(Cookie::get('antlangsiigef'))
        {
            $idioma=Cookie::get('antlangsiigef');    
           
        }
        else
        {         
            $idioma =  $this->lenguaje();               
            Session::set('antlangsiigef', $idioma);
            Cookie::set('antlangsiigef',$idioma);         
        }

        return $idioma;       
    }   
     public static function setLenguaje($lang)
     {    
        Cookie::setantLenguaje(Cookie::lenguaje());    
        Session::set('langsiigef', $lang);
        Cookie::set('langsiigef',$lang);
                      
     }

     public static function setantLenguaje($lang)
     {    
        Session::set('antlangsiigef', $lang);
        Cookie::set('antlangsiigef',$lang);                      
     }
        
    public static function tiempo()
    {
        if(!Session::get('tiempo') || !defined('SESSION_TIME'))
        {
            throw new Exception('No se ha definido el tiempo de sesion'); 
        }
        
        if(SESSION_TIME == 0)
        {
            return;
        }
        
        if(time() - Session::get('tiempo') > (SESSION_TIME * 60))
        {
            Session::destroy();
            header('location:' . BASE_URL . 'error/access/8080');
        }
        else
        {
            Session::set('tiempo', time());
        }
    }
}

?>