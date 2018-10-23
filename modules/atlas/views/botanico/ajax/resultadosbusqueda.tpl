<div id="lista_registros">                                         
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>#<th>{$lenguaje["label_nombrecientifico_botanico"]}<th>{$lenguaje["label_familia_botanico"]}<th>{$lenguaje["metadata_genero_botanico"]}<th>{$lenguaje["label_nombrecomun_botanico"]}<th>Institución<th>{$lenguaje["label_h2_metadata_titulo"]}
                                <tbody>
                                    {foreach item=datos from=$registros}
                                    <tr><td> {$numeropagina++}<td>{ucwords(strtolower($datos.Pli_NombreCientifico))}<td>{ucwords(strtolower($datos.Pli_Orden))}<td>{ucwords(strtolower($datos.Pli_Familia))}<td>{ucwords(strtolower($datos.Pli_NombresComunes))}<td>{ucwords(strtolower($datos.Pli_AcronimoInstitucion))}<td><a data-toggle="tooltip" href="botanico/metadata/{$datos.Pli_IdPlinian}"   target="_blank" data-original-title="{$lenguaje["enlace_vermetadata_botanico"]}"><button type="button" id="btnBuscar" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>             
                                        {/foreach}
                                    </tbody>
                                </table>
                                {if !empty(count($datos))}
                                {$paginacion|default:""}
                                {else}
                                <center>¡¡¡No se encontraron resultados!!!</center>
                                {/if}
                            </div>
                        </div>