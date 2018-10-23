<script type="text/javascript">
    {literal}var cat_ErroresComunes = [{/literal}
    {foreach from=$ErroresComunes item=b}'{$b.descripcion}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_ErroresComunes = [{/literal}
    {foreach from=$ErroresComunes item=b}{$b.N},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_ErroresComunes(cat_ErroresComunes, dat_ErroresComunes, titulo);
</script>