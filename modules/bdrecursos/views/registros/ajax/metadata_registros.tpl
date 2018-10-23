<table class="table table-user-information">          
    <tbody>
        <tr>
            <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">
                <b>{$lenguaje["label_detalle"]} {$nombre_tabla}</b>
            </td>
            <td class="col-md-9" style="padding:0;border: 0;">
                <table class="table table-user-information" style="margin:0;border:0;">
                    <tbody>                                                    
                        {foreach from=$lista_variable item=lv}
                        <tr>                                               
                            <td class="col-md-5 text-right">{$lv.$campo_etiqueta} :</td>
                            <td>
                                {$lista_data[0][$lv[$campo_nombre]]}
                            </td>                                  
                        <tr>                                                
                        {/foreach}                                                    
                    </tbody>                                    
                </table>                                        
            </td>                                    
    </tbody>
</table>
<div class="panel-footer">
    {$paginacion|default:""}
</div>  