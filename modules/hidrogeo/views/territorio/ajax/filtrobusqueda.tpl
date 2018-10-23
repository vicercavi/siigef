<div class="form-group ">
    <div class="col-xs-3" >                        
        {if isset($paises)}
            <select class="form-control" id="buscarPais" name="buscarPais">
                <option value="">{$lenguaje.label_todos_paises}</option>
                {foreach from=$paises item=p}
                    <option value="{$p.Pai_IdPais}" {if isset( $fl_pais) && $fl_pais==$p.Pai_IdPais}selected{/if}>{$p.Pai_Nombre}</option>    
                {/foreach}
            </select>
        {/if}
    </div>
    <div class="col-xs-3">
        {if isset($denominaciones)}
            <select class="form-control" id="buscarDenominacion" name="buscarDenominacion" required="">
                <option value="">{$lenguaje.label_todos_denominaciones}</option>
                {foreach from=$denominaciones item=d}
                    <option value="{$d.Det_IdDenomTerrit}" {if isset( $fl_denominacion) && $fl_denominacion==$d.Det_IdDenomTerrit}selected{/if}>{$d.Det_Nombre}</option>    
                {/foreach}
            </select>
        {/if}
    </div>
    <div class="col-xs-3">
        <input class="form-control" placeholder="{$lenguaje.text_buscar_territorio}"  name="palabra" id="palabra">                        
    </div>
    <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
</div>