{if  isset($subcuencas) && count($subcuencas)}
<div class="col-xs-3">
    <select class="form-control" id="buscarSubcuenca" name="buscarSubcuenca">
        <option value="0">{$lenguaje.label_todos_subcuencas}</option>        
            {foreach from=$subcuencas item=s}
            <option value="{$s.Suc_IdSubcuenca}">{$s.Suc_Nombre}</option>
            {/foreach}        
    </select>
</div>
{/if}