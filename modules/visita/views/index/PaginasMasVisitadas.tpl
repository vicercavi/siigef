<script type="text/javascript">
    {literal}var cat_PaginasMasVisitadas = [{/literal}
    {foreach from=$PaginasMasVisitadas item=b}'{$b.descripcion}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_PaginasMasVisitadas = [{/literal}
    {foreach from=$PaginasMasVisitadas item=b}{$b.N},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_PaginasMasVisitadas(cat_PaginasMasVisitadas, dat_PaginasMasVisitadas, titulo);
</script>