<script type="text/javascript">
    {literal}var cat_Busqueda = [{/literal}
    {foreach from=$Busqueda item=b}'{$b.Esb_PalabraBuscada}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_Busqueda = [{/literal}
    {foreach from=$Busqueda item=b}{$b.Cantidad},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_Busqueda(cat_Busqueda, dat_Busqueda, titulo);
</script>