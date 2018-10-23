{if  isset($denominaciones[0])}
          <div class="form-group">                                 
              <label class="col-md-4 control-label">{$denominaciones[0]['Det_Nombre']} : </label>
              <div class="col-md-5">
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
              <label class="col-md-4 control-label">{$denominaciones[1]['Det_Nombre']} : </label>
              <div class="col-md-5">
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
              <label class="col-md-4 control-label">{$denominaciones[2]['Det_Nombre']} : </label>
              <div class="col-md-5">
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
              <label class="col-md-4 control-label">{$denominaciones[3]['Det_Nombre']} : </label>
              <div class="col-md-5">
                  <select class="form-control" id="selTerritorio4" name="selTerritorio4" required="">
                      <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                      {foreach from=$territorios4 item=t}
                          <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio4) && $sl_territorio4==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                      {/foreach}
                  </select>
              </div>
          </div>
      {/if}