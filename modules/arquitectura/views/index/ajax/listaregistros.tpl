{if isset($arquitectura) && count($arquitectura)}
<div class="table-responsive" >
    <table class="table">
        <tr>
            <th>#</th>
            <th>{$lenguaje.label_nombre}</th>
            <th>{$lenguaje.label_orden}</th>
            <th>{$lenguaje.label_descripcion}</th>
            <th>{$lenguaje.label_tipo}</th>
            <th style=" text-align: center">{$lenguaje.label_estado}</th>
            <th style=" text-align: center">{$lenguaje.label_opciones}</th>
        </tr>
        {foreach from=$arquitectura item=ar}

            <tr>
                <td>{$numeropagina++}</td>
                <td>{$ar.Pag_Nombre}</td>
                <td>{$ar.Pag_Orden}</td>
                <td>{$ar.Pag_Descripcion}</td>
                <td>
                    {if $ar.Pag_TipoPagina==1}{$lenguaje.arquitectura_buscar_opcion1}{/if}
                    {if $ar.Pag_TipoPagina==2}{$lenguaje.arquitectura_buscar_opcion2}{/if}
                    {if $ar.Pag_TipoPagina==3}{$lenguaje.arquitectura_buscar_opcion3}{/if}
                </td>
                <td style=" text-align: center">
                    {if $ar.Pag_Estado==0}
                        <p class="glyphicon glyphicon-remove-sign " title="Desabilitado" style="color: #DD4B39;"></p>
                    {/if}                            
                    {if $ar.Pag_Estado==1}
                        <p class="glyphicon glyphicon-ok-sign " title="Habilitado" style="color: #088A08;"></p>
                    {/if}
                </td>
                <td style=" text-align: center">
                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="Editar Principal" href="{$_layoutParams.root}arquitectura/index/index/{$ar.Pag_IdPagina}"> </a>
                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-edit" title="Editar Contenido Principal"  href="{$_layoutParams.root}arquitectura/index/index/{$ar.Pag_IdPagina}/{$ar.Pag_IdPagina}"> </a>
                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh cambiarEstadoPagina" title="{$lenguaje.tabla_opcion_cambiar_est}" Pag_IdPagina="{$ar.Pag_IdPagina}" Pag_Estado="{$ar.Pag_Estado}"> </a>
                </td>
            </tr>
        {/foreach}
    </table>
</div>
{$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}