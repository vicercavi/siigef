{if  isset($idiomas) && count($idiomas)}
    <ul class="nav nav-tabs ">
    {foreach from=$idiomas item=idi}
        <li role="presentation" class="{if $datos.Idi_IdIdioma==$idi.Idi_IdIdioma} active {/if}">
            <a class="idioma_s" id="idioma_{$idi.Idi_IdIdioma}" href="#">{$idi.Idi_Idioma}</a>
            <input type="hidden" id="hd_idioma_{$idi.Idi_IdIdioma}" value="{$idi.Idi_IdIdioma}" />
            
        </li>    
    {/foreach}
    </ul>
{/if}
<div class="panel panel-default">
    <div class="panel-heading ">
        <h3 class="panel-title "><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>NUEVO ESTANDAR</strong></h3>
    </div>
    <div class="panel-body">
        <div id="nuevoRegistro">

            <div style="width: 90%; margin: 0px auto">

                <form class="form-horizontal" id="form1" name="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">

                    {if  isset($ficha) && count($ficha)}
                        <input type="hidden" id="Rec_IdRecurso" name="Rec_IdRecurso" value="{$idRecurso}" />
                        {if  isset($datos) && count($datos)}
                        <input type="hidden" id="Reg_IdRegistro" name="Reg_IdRegistro" value="{$datos[0]}" />
                        <input type="hidden" id="Idi_IdIdioma" name="Idi_IdIdioma" value="{$datos.Idi_IdIdioma}" />
                        {/if}
                        {foreach from=$ficha item=fi}
                            <div class="form-group">                                    
                                <label class="col-lg-3 control-label">{$fi.Fie_CampoFicha} :</label>
                                <div class="col-lg-8">
                                    
                                    <input class="form-control" id ="{$fi.Fie_ColumnaTabla}" name="{$fi.Fie_ColumnaTabla}" type="text" value="{$datos.{$fi.Fie_ColumnaTabla}}" {if $fi.Fie_ColumnaTraduccion==0 } disabled ="disabled" {/if}
                                           placeholder="{$fi.Fie_CampoFicha} ({if $fi.Fie_TipoDatoCampo=="int"} Entero {/if}{if $fi.Fie_TipoDatoCampo=="double"} Decimal {/if}{if $fi.Fie_TipoDatoCampo=="varchar" } Texto {/if})" {if $fi.Fie_ColumnaObligatorio==1 } required="" {/if}/>                                            
                                
                                </div>
                            </div>
                        {/foreach}
                    {/if}

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-8">
                        <button class="btn btn-success" id="bt_guardarRegistro" name="bt_guardarRegistro" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>