
<table class="table table-hover table-condensed">
  <thead>
    <tr><th>#<th>{$lenguaje["tabla_campo_titulo"]}<th>{$lenguaje["tabla_campo_descripcion_documentos"]}<th>{$lenguaje["tabla_campo_pais_documentos"]}
    <tbody>
       {if isset($documentos) && count($documentos)}
                {$numero = 1}
                {foreach item=datos from=$documentos}
                    <tr class="text-justify">
                        <td>{$numero++}<td><a data-toggle="tooltip" data-placement="top" href="{$_layoutParams.root}dublincore/documentos/metadata/{$datos.Dub_IdDublinCore}" target="_blank" title="{$lenguaje["tabla_campo_detalle_documentos"]}"> {$datos.Dub_Titulo} </a><td>{$datos.Aut_Nombre}<br/><div data-toggle="tooltip" data-placement="right" title="{$datos.Dub_Descripcion}">{$datos.Dub_Descripcion}</div>
                        <td>{if isset($datos.Pai_Nombre) && $datos.Pai_Cantidad == 1} <img data-toggle="tooltip" data-placement="top" title="{$datos.Pai_Nombre}" class="pais " style="width:40px" src="{$_layoutParams.root}public/img/legal/{$datos.Pai_Nombre}.png"/> {else} Varios {/if}
                         
                {/foreach}                       
                                                       
            {/if}   
    </tbody>
</table>
