{if isset($tematicas) && count($tematicas)}

    {foreach from=$tematicas key=key item=jerarquia name=i} 
        <li > 
            <a href="#">{$jerarquia.jem_Nombre}</a>           
            {if isset($jerarquia.capas)}
                <ul class="list">
                    {foreach from=$jerarquia.capas key=key2 item=capa name=j} 
                        <li class="list__item list__item--tappable">
                            <label class="checkbox checkbox--list-item">
                                <input type="checkbox"  id="cb_layer{$capa.tic_Nombre}_{$smarty.foreach.j.index}">
                                <div class="checkbox__checkmark checkbox--list-item__checkmark"></div>                              
                                {$capa.Cap_Titulo}
                                <input type="hidden" id="hd_layern_{$smarty.foreach.j.index}" value="{$capa.Cap_Nombre}">
                                <input type="hidden" id="hd_layer_{$smarty.foreach.j.index}" value="{$capa.Cap_UrlCapa}">
                                <input type="hidden" id="hd_layerb_{$smarty.foreach.j.index}" value="{$capa.Cap_UrlBase}">
                            </label>
                              <input id="r_layer{$capa.tic_Nombre}_{$smarty.foreach.j.index}" type="range" value="100" />                                    
                                              
                        </li>
                    {/foreach}
                </ul> 
            {/if}
        </li>       
    {/foreach}
{else}
    <p><strong>No hay registros!</strong></p>

{/if}
