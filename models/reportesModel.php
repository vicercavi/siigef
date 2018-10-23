<?php

class reportesModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
      public function ListaEstacionPais($idpais){
         $post = $this->_db->query("SELECT DISTINCT (epm.Epm_IdEstacion),".
                 "epm.Epm_Nombre FROM estacion_punto_monitoreo epm".
                 "INNER JOIN monitoreo_calidad_agua  mca ON mca.Epm_Codigo=epm.Epm_Codigo".
                 "WHERE mca.Pai_IdPais=$idpais");
        return $post->fetchAll();
    }
    
    public function ListaVariableEstacion($idestacion){
         $post = $this->_db->query("SELECT DISTINCT (p.Par_IdParametro),p.Par_Nombre FROM monitoreo_calidad_agua mca".
                 "INNER JOIN estacion_punto_monitoreo  epm ON epm.Epm_Codigo=mca.Epm_Codigo".
                 "INNER JOIN parametro p ON p.Par_IdParametro = mca.Par_IdParametro".
                 "WHERE epm.Epm_IdEstacion=$idestacion");
        return $post->fetchAll();
    }
    
     public function VariableValor($idvariable){
         $post = $this->_db->query("SELECT DISTINCT (p.Par_IdParametro),p.Par_Nombre FROM monitoreo_calidad_agua mca".
                 "INNER JOIN estacion_punto_monitoreo  epm ON epm.Epm_Codigo=mca.Epm_Codigo".
                 "INNER JOIN parametro p ON p.Par_IdParametro = mca.Par_IdParametro".
                 "WHERE epm.Epm_IdEstacion=$idestacion");
        return $post->fetchAll();
    }
}

?>
