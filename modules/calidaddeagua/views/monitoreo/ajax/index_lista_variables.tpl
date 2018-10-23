{if isset($variables) && count($variables)}
    {foreach from=$variables key=key item=tipo name=i} 
        <li class="dimli"> 
            <label class="tree-toggler" >{$tipo.Tiv_Nombre}</label>
            {if isset($tipo.params)}
                <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas ul_parametros">
                    {foreach from=$tipo.params key=key2 item=variable name=j} 
                        <li class="dimli subitem">
                            <input type="checkbox" id="cb_parametros_{$smarty.foreach.j.index}" name="parametro[]" value="{$variable.Var_IdVariable}">                            
                            <label class="tree-toggler" >{$variable.Var_Nombre}</label>                           
                        </li>
                    {/foreach}
                </ul> 
            {/if}
        </li>
        <li class="divider"></li>    

    {/foreach}


{else}

    <p><strong>No hay registros!</strong></p>

{/if}
