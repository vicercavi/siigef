<script type="text/javascript">
    {literal}var cat_PaginaErrores = [{/literal}
    {foreach from=$PaginaErrores item=b}'{$b.descripcion}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_PaginaErrores = [{/literal}
    {foreach from=$PaginaErrores item=b}{$b.N},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_PaginaErrores(cat_PaginaErrores, dat_PaginaErrores, titulo);
</script>