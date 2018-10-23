<script type="text/javascript">
    {literal}var cat_IpMasFrecuentes = [{/literal}
    {foreach from=$IpMasFrecuentes item=b}'{$b.descripcion}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_IpMasFrecuentes = [{/literal}
    {foreach from=$IpMasFrecuentes item=b}{$b.N},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_IpMasFrecuentes(cat_IpMasFrecuentes, dat_IpMasFrecuentes, titulo);
</script>