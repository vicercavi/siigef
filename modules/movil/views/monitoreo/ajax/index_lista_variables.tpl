{if isset($variables) && count($variables)}
    {foreach from=$variables key=key item=tipo name=i} 
        <li> 
            <a href="#">{$tipo.Tiv_Nombre}</a>          
            {if isset($tipo.params)}
                <ul class="list ul_parametros">
                    {foreach from=$tipo.params key=key2 item=variable name=j} 
                        <li class="list__item list__item--tappable">
                            <label class="checkbox checkbox--list-item">                               
                                <input type="checkbox" id="cb_parametros_{$smarty.foreach.j.index}" name="parametro[]" value="{$variable.Var_IdVariable}">                            
                                <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>
                                {$variable.Var_Nombre}
                            </label>
                        </li>
                    {/foreach}
                </ul> 
            {/if}
        </li>
    {/foreach}
{else}
    <p><strong>No hay registros!</strong></p>
{/if}
