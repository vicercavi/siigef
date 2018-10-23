<div style="width: 90%; margin: 0px auto">                        
    <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
        <!--                            <input type="hidden" value="1" name="enviar" />-->   
        <div class="form-group">                                 
            <label class="col-lg-3 control-label">{$lenguaje.label_pais_nuevo} : </label>
            <div class="col-lg-8">
                {if  isset($paises)}
                    <select class="form-control" id="selPais" name="selPais" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                        {foreach from=$paises item=p}
                            <option value="{$p.Pai_IdPais}" {if isset( $sl_pais) && $sl_pais==$p.Pai_IdPais}selected{/if}>{$p.Pai_Nombre}</option>    
                        {/foreach}
                    </select>
                {/if}
            </div>
        </div>
        {if  isset($denominaciones[0])}
            <div class="form-group">                                 
                <label class="col-lg-3 control-label">{$denominaciones[0]['Det_Nombre']} : </label>
                <div class="col-lg-8">

                    <select class="form-control" id="selTerritorio1" name="selTerritorio1" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                        {foreach from=$territorios1 item=t}
                            <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio1) && $sl_territorio1==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                        {/foreach}
                    </select>

                </div>
            </div>
        {/if}
        {if  isset($denominaciones[1])}
            <div class="form-group">                                 
                <label class="col-lg-3 control-label">{$denominaciones[1]['Det_Nombre']} : </label>
                <div class="col-lg-8">

                    <select class="form-control" id="selTerritorio2" name="selTerritorio2" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                        {foreach from=$territorios2 item=t}
                            <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio2) && $sl_territorio2==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                        {/foreach}
                    </select>

                </div>
            </div>
        {/if}
        {if  isset($denominaciones[2])}
            <div class="form-group">                                 
                <label class="col-lg-3 control-label">{$denominaciones[2]['Det_Nombre']} : </label>
                <div class="col-lg-8">

                    <select class="form-control" id="selTerritorio3" name="selTerritorio3" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                        {foreach from=$territorios3 item=t}
                            <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio3) && $sl_territorio3==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                        {/foreach}
                    </select>

                </div>
            </div>
        {/if}
        {if  isset($denominaciones[3])}
            <div class="form-group">                                 
                <label class="col-lg-3 control-label">{$denominaciones[3]['Det_Nombre']} : </label>
                <div class="col-lg-8">

                    <select class="form-control" id="selTerritorio4" name="selTerritorio4" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                        {foreach from=$territorios4 item=t}
                            <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio4) && $sl_territorio4==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                        {/foreach}
                    </select>

                </div>
            </div>
        {/if}
        <div class="form-group">                                 
            <label class="col-lg-3 control-label">{$lenguaje.label_estado_nuevo} : </label>
            <div class="col-lg-8">
                <select class="form-control" id="selEstado" name="selEstado" >
                    <option value="0">Inactivo</option>
                    <option value="1">Activo</option>
                </select>

            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
                <button class="btn btn-success" id="bt_guardar" name="bt_guardar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
            </div>
        </div>
    </form>
</div>    