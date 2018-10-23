<style>
body{
    background: #fff;
}
.container{
    height: 105% !important;
    padding: 0px !important;
}
.map{
    margin-bottom: 50px !important;
}
#navbar-toggle-menuvisor{
    left: 10px ;
    position: absolute !important;
    z-index: 10;
    font-size: x-large;
}

@media(min-width: 768px){
    .map {
        height: 80%;
    }
    .template-content .container{
        height: 92% !important;
        position: fixed;
    }
    .navbar-fixed-bottom {
        padding-top: 5px;
        height: 65px;
    }
}
 
@media (min-width: 1024px) {

}

@media (min-width: 1200px){
    
    .template-content .container{
        margin-top: 1px !important;
        height: 95% !important;
        position: fixed;
    }
    .navbar-fixed-bottom {
        padding-top: 10px;
        height: 70px;
    }
    .map {
        height: 76.6% !important;
    }
} 
@media (min-width: 1366px) {
    .template-content .container{
        margin-top: 1px !important;
        height: 100% !important;
        position: fixed;
    }
    .navbar-fixed-bottom {
        padding-top: 10px;
        height: 70px;
    }
}
@media (max-width: 767px){
    #navbar-toggle-menuvisor{
        left: 5px;
    }
    .well {
        margin-top: 20px;
    }
    .template-content .container{
        height: 60.5% !important;
        position: fixed;
    }
    #menuvisor{
        margin-left: 50px !important;
    }
    .navbar-fixed-bottom {
        padding-top: 5px;
        min-height: 61px;
    }
}
@media(max-width: 567px){
    .template-content .container{
        height: 55% !important;
    }
    #navbar-toggle-menuvisor{
        left: 5px;
    }
}
@media (max-width: 480px) { 
    .map {
        height: 80.5%;
    }
    .template-content .container{
        height: 74.5% !important;
    }
}


  
</style> 
<button type="button" id="navbar-toggle-menuvisor" class=" navbar-toggle collapsed col-xs-1" data-toggle="collapse" data-target="#menuvisor" >
    <i class="glyphicon glyphicon-list"></i>
</button>

<div id="menuvisor" class="well span5 visor collapse navbar-collapse">
    <h4 class="panel-title title-sidebar" style="width: 100%;text-align: center;font-weight: bold;">
        <a href="#" style="width:90%;display:inline-block" data-toggle="modal" data-target="#basicModal3">{$herramienta.Her_Nombre|upper}</a> 
        {if $herramienta.Her_Abreviatura=="biodiversidad"}
            <span class="glyphicon glyphicon-search" aria-hidden="true" style="width: 8%;display:inline-block;vertical-align: top;cursor: pointer" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0"></span>
        {/if}
    </h4>  
    

    <div id="contenido" class="scroll" style="overflow-y: auto; overflow-x: hidden; max-height: 400px;"> 
        <div id="collapse0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">  
            {if $herramienta.Her_Abreviatura=="biodiversidad"}              
                <div class="input-group col-xs-12 ">
                    <input id="tb_buscar_especie" type="text" class="form-control"  placeholder="{$lenguaje.placeholder_busqueda_nc|default}" value="{$buscar|default}" />                     
                    <span class="input-group-btn">
                        <button id="bt_buscar_especie" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        <button id="bt_cancelar_especie" class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                    </span>
                </div> 
            {/if}
        </div>

        <ul id="div_lita_variables"  class="nav nav-list tree dimul dos_columnas">                              
            {$arbolherramienta|default:"No existe datos"}
        </ul> 
        <ul class="nav nav-list">
            <li>
                <label class="tree-toggler nav-header" role="tab" id="heading3">
                    <h4 class="panel-title" style="font-size: 13px;">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>     <a id="ver-recursos" href="#" data-toggle="modal" data-target="#basicModal4">{$lenguaje.label_lista_recurso|default}</a>
                    </h4>
                </label> 
            </li>         
        </ul>
        
        <input type="hidden" id="hd_id_visor" value="{$herramienta.Her_IdHerramientaSii}" >
    </div>
</div>

<!-- ESTE ES EL Modal-->
    <div class="modal fade basicModal" id="basicModal3" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title" id="myModalLabel">{$herramienta.Her_Nombre|upper}</h4>
                </div>
                <div class="modal-body">
                    <p class="text-justify">{$herramienta.Her_Descripcion}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{$lenguaje.label_cerrar|default}</button>  
                </div>
            </div>
        </div>
    </div>
<!--FIN DEL MODAL -->

<!-- ESTE ES EL Modal-->
    <div class="modal fade basicModal modal-recurso" id="basicModal4" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title" id="myModalLabel">{$lenguaje.label_lista_recurso|default}: {$herramienta.Her_Nombre|upper}</h4>
                </div>
                <!--table class="table table-hover table-condensed" data-toggle="table" data-url="/siigef/herramienta/_listaRecursos/1" data-cache="false" data-height="400" data-sort-name="Rec_Nombre" data-sort-order="desc">
                      <thead>
                          <tr>
                              <th data-field="Rec_Nombre"  data-sortable="true">{$lenguaje.label_Nombre|default}</th>
                              <th data-field="Tir_Nombre"  data-sortable="true">{$lenguaje.label_Tipo|default}</th>
                              <th data-field="Esr_Nombre"  data-sortable="true">{$lenguaje.label_Estandar|default}</th>
                              <th data-field="Rec_Fuente"  data-sortable="true">{$lenguaje.label_Fuente|default}</th>
                              <th data-field="Rec_Origen">{$lenguaje.label_Origen|default}</th>
                              <th data-field="Rec_CantidadRegistros">{$lenguaje.label_Registros|default}</th>
                          </tr>
                      </thead>
                  </table-->                
                <div id="visor_lista_recursos" >
                    {if isset($recursos)}
                        <div class="table-responsive">
                            <table id="lista-recurso" data-toggle="table" class="table table-hover table-condensed"  data-sort-name="Rec_N" data-sort-order="asc" 

                                   >
                                <thead>
                                    <tr>
                                        <th data-sortable="true" data-field="Rec_N">#</th>
                                        <th data-field="Rec_Nombre"  data-sortable="true">{$lenguaje.label_Nombre|default}</th>
                                        <th data-field="Tir_Nombre"  data-sortable="true">{$lenguaje.label_Tipo|default}</th>
                                        <th data-field="Esr_Nombre"  data-sortable="true">{$lenguaje.label_Estandar|default}</th>
                                        <th data-field="Rec_Fuente"  data-sortable="true">{$lenguaje.label_Fuente|default}</th>
                                        <!--th data-field="Rec_Origen">{$lenguaje.label_Origen|default}</th-->
                                        <th data-field="Rec_CantidadRegistros">{$lenguaje.label_Registros|default}</th>
                                        <th></th> 

                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item=datos from=$recursos}
                                        <tr>                       
                                            <td>{$numeropagina++}</td>
                                            <td>{$datos.Rec_Nombre}</td>
                                            <td>{$datos.Tir_Nombre}</td>
                                            <td>{$datos.Esr_Nombre}</td>
                                            <td>{$datos.Rec_Fuente}</td>
                                            <!--td>{$datos.Rec_Origen}</td-->
                                            <td>{$datos.Rec_CantidadRegistros }</td>  
                                            <td> <a type="button" title="{$lenguaje.label_ver|default}" target="_blank" class="btn btn-default btn-sm glyphicon glyphicon-list" href="{$_layoutParams.root}bdrecursos/metadata/index/{$datos.Rec_IdRecurso}"></a></td>
                                        </tr>                     
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>        
                    {/if}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{$lenguaje.label_cerrar|default}</button>  
                </div>
            </div>
        </div>
    </div>
<!--FIN DEL MODAL -->

<div id='map' class="map" > <div id='gmap' class="fill" ></div>  <div id="olmap" class="fill"></div></div>
<a class="leyendas nav-toggle" id="btleyenda" data-toggle="tooltip" data-placement="left" title="{$lenguaje.label_leyenda|default}" ><img src="{$_layoutParams.ruta_img}ic-leyenda.png"></a>
<div id="cont-leyenda" style="display:none">
    <div class="well">
        <a href="index.tpl"></a>
        <h4 class="panel-title title-sidebar" style="width: 100%;font-weight: bold;">
            <img class="ocultar-leyenda" src="{$_layoutParams.ruta_img}ic-leyenda2.png">&nbsp;&nbsp;{$lenguaje.label_leyenda|default}
        </h4>
    </div>
    <div id="contenido" class="scroll" style="overflow-y: auto; overflow-x: hidden; max-height: 400px;">
        <div class="item-leyenda" id="item-leyenda">

        </div>
    </div>
</div>

<script type="text/javascript">
    var eh_predeterminado = JSON.parse('{$eh_predeterminado|default:""}');   
   // AgregarControlMap(google.maps.ControlPosition.RIGHT_CENTER,$('#menuvisor')[0]);
    //$('#menuvisor').remove();
</script>
