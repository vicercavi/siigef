<?php

class menuWidget extends Widget
{
    private $modelo;
    
    public function __construct(){
        $this->modelo = $this->loadModel('menu');
    }
    
    public function getMenu($menu, $view, $inverse = null)
    {        
        if ($menu=='top') {
            $view="menu_".$menu;
            $data = $this->modelo->getMenus(1,0);
        }
        if ($menu=='sidebar') {
            $view="menu_".$menu;
            $data = $this->modelo->getMenus(2,0);
        }
        
        if ($menu=='footer') {
            $view="menu_".$menu;
            $data = $this->modelo->getFooter(3,0,57);
        }
        
       // $data['menu'] = $this->modelo->getMenus($menu);   
        //$data = $this->modelo->getMenus();
        //$data['inverse'] = $inverse;
        /*echo "menu";
        echo $menu;
        echo "vista";
        echo $view;*/
        $arbol = new Arbol();

        return $arbol->enrraizar($data, $view);
       // return $this->render($view, $data);
    }
    
    
    public function getConfig($menu)
    {
        $menus['sidebar'] = array(
            'position' => 'sidebar',
            'show' => 'all'
           // 'hide' => 'all'
        );
        
        $menus['top'] = array(
            'position' => 'top',
            'show' => 'all'
           // 'hide' => array('inicio','usuarios','arquitectura')
            
        );
        
        $menus['footer'] = array(
            'position' => 'footer',
            'show' => 'all'
           // 'hide' => array('inicio','usuarios','arquitectura')
            
        );
        
        return $menus[$menu];
    }
    
   
}

?>