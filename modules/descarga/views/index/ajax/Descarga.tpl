<script type="text/javascript">
    {literal}var cat_Descarga = [{/literal}
    {foreach from=$Descarga item=d}'{$d.Arf_PosicionFisica}',{/foreach}
    {literal}];{/literal}
    {literal}var dat_Descarga = [{/literal}
    {foreach from=$Descarga item=d}{$d.Cantidad},{/foreach}
    {literal}];{/literal}
    {literal}var titulo = {/literal}'{$titulo}'{literal};{/literal}
    fun_Descarga(cat_Descarga, dat_Descarga, titulo);
</script>