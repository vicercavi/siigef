<script type="text/javascript">
    {literal}var cat_OrigenesDeVisitas = [{/literal}
    {foreach from=$OrigenesDeVisitas item=b}'{$b.descripcion}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_OrigenesDeVisitas = [{/literal}
    {foreach from=$OrigenesDeVisitas item=b}{$b.N},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_OrigenesDeVisitas(cat_OrigenesDeVisitas, dat_OrigenesDeVisitas, titulo);
</script>