{if isset($recursos)}
    <div class="table-responsive">
        <table class="table table-hover table-condensed" >
            <tr>
                <th>#</th>
                <th>{$lenguaje.label_Nombre|default}</th>                   
                <th>{$lenguaje.label_Tipo|default}</th>
                <th>{$lenguaje.label_Estandar|default}</th>
                <th>{$lenguaje.label_Fuente|default}</th>
                <!--th>{$lenguaje.label_Origen|default}</th--> 
                <th>{$lenguaje.label_Registros|default}</th> 
                <th></th> 

            </tr>
            {$item=1}
            {foreach item=datos from=$recursos}

                <tr>                       
                    <td>{$numeropagina++}</td>
                    <td>{$datos.Rec_Nombre}</td>
                    <td>{$datos.Tir_Nombre}</td>
                    <td>{$datos.Esr_Nombre}</td>
                    <td>{$datos.Rec_Fuente}</td>
                    <!--td>{$datos.Rec_Origen}</td-->
                    <td>{$datos.Rec_CantidadRegistros }</td>  
                    <td> <a type="button" title="{$lenguaje.label_ver|default}" target="_blank" class="btn btn-default btn-sm glyphicon glyphicon-list" href="{$_layoutParams.root}bdrecursos/metadata/{$datos.Rec_IdRecurso}"></a></td>
                </tr>                     
            {/foreach}
        </table>
    </div>

    {$paginacion|default:""}                           
{/if}