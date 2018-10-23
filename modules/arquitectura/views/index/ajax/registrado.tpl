{if isset($_error)}
    <div id="_errl" class="alert alert-error ">
        <a class="close" data-dismiss="alert">x</a>
        {$_error}
    </div>
{/if}

{if isset($_mensaje)}
    <div id="_msgl" class="alert alert-success">
        <a class="close" data-dismiss="alert">x</a>
        {$_mensaje}
    </div>
{/if}