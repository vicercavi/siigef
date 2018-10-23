
<div class="center-block text-center">
    <h3>{if isset($mensaje)} {$mensaje}{/if}</h3>
    <p>&nbsp;</p>
    <a href="{$_layoutParams.root}">{$lenguaje.label_irinicio|default}</a> | 
    <a href="javascript:history.back(1)">{$lenguaje.label_volver|default}</a>

    {if (!Session::get('autenticado'))}
        | <a href="{$_layoutParams.root}usuarios/login/index/{$data}">{$lenguaje.label_iniciarsesion|default}</a>
    {/if}
</div>
