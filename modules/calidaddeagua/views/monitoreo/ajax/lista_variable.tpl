{if isset($variables) && count($variables)}                            
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th> 
                                <th>Abreviatura</th> 
                                <th>Unidad de Medida</th>   
                                <th>Tipo</th>                                           
                                <th>Opciones</th>

                            </tr>
                        </thead>
                        {foreach item=datos from=$variables key=key name=i}
                            <tr>
                                <td>{{$numeropagina_var++}}</td>
                                <td>{$datos.Var_Nombre}</td>
                                <td>{$datos.Var_Abreviatura}</td>
                                <td>{$datos.Var_Medida}</td>
                                <td>{$datos.Tiv_Nombre}</td>
                                <td>
                                    <!--<a type="button" title="Editar" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="#"></a>-->                                                
                                    <a type="button" title="Ver" class="btn btn-default btn-sm glyphicon glyphicon-eye-open" target="_blank" href="{$_layoutParams.root}calidaddeagua/monitoreo/variable/{$datos.Var_IdVariable}"></a>
                                    </a>
                                </td>

                            </tr>

                        {/foreach}
                    </table> 

                    {$paginacion_variables|default}
                    {else}
                        <p><strong>No hay registros!</strong></p>
                    {/if}