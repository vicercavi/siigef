<div class="table-responsive">
  <table class="table table-hover table-condensed">
    <thead>
      <tr>
        <th>#</th>                       
        <th>{$lenguaje["tabla_campo_titulo"]}</th>
        <th>{$lenguaje["tabla_campo_entidad"]}</th>
        <th>{$lenguaje["tabla_campo_tipo_legislacion"]}</th>
        <th>{$lenguaje["tabla_campo_pais"]}</th>
        <th>{$lenguaje["tabla_campo_fecha_publicacion"]}</th>
        <th>{$lenguaje["tabla_campo_detalle"]}</th>
      </tr>
    </thead>
    <tbody>
      {if isset($legislacion)}
        {foreach item=datos from=$legislacion}
          <tr>
            <td data-th="Nro">{$numeropagina++}</td>
            <td data-th="Titulo">{$datos.Mal_Titulo} </td>
            <td data-th="Entidad">{$datos.Mal_Entidad} </td>
            <td data-th="Tipo Legislación">{$datos.Til_Nombre}</td>
            <td data-th="Pais"><img style="width:40px" src="{$_layoutParams.root}public/img/legal/{$datos.Pai_Nombre}.png" /> </td>
            <td data-th="Fecha de Publicacion">{$datos.Mal_FechaPublicacion}  </td>
            <td data-th="Detalle"><a data-toggle="tooltip" data-placement="top" class="btn btn-default" href="{$_layoutParams.root}legislacion/legal/metadata/{$datos.Mal_IdMatrizLegal}" target="_blank" data-original-title="Ver Ficha"><i class="glyphicon glyphicon-list-alt" ></i></a></td>
          </tr>
        {/foreach}
      {else}
      <tr>
        <td colspan="7">No se Encontraron Registros </td>
      {/if}
      </tr>
    </tbody>
  </table>
</div>
<div class="panel-footer">  
  {if isset($legislacion) && count($legislacion)}
    {$paginacion|default:""}
  {/if}
</div>