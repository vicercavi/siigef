<script type="text/javascript">
    {literal}var cat_Explorador = [{/literal}
    {foreach from=$Explorador item=b}'{$b.descripcion}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_Explorador = [{/literal}
    {foreach from=$Explorador item=b}{$b.N},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_Explorador(cat_Explorador, dat_Explorador, titulo);
</script>