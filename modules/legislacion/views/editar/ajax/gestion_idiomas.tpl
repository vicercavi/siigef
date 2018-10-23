<input type="hidden" id="idiomaSelect" name="idiomaSelect" value="{$datos1.Idi_IdIdioma}" />            
{if  isset($idiomas) && count($idiomas)}            
    <ul class="nav nav-tabs ">
        {foreach from=$idiomas item = idi}                  
            <li role="presentation" {if $idi.Idi_IdIdioma == $datos1.Idi_IdIdioma} class = "active" {/if}>
                <a class="idioma_s" id="idioma_{$idi.Idi_IdIdioma}" href="#">{$idi.Idi_Idioma}</a>
                <input type="hidden" id="hd_idioma_{$idi.Idi_IdIdioma}" value="{$idi.Idi_IdIdioma}"/>
            </li>    
        {/foreach}
    </ul>
{/if}
<div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="nivel_legal" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']} (*)</label>
            <div class="col-md-6">    
                <input type='hidden' value="{$datos1.Nil_IdNivelLegal|default:''}" id="Nil_IdNivelLegal" name="Nil_IdNivelLegal" />
                <input type="text" list="nivel_legal" value="{$datos1.Nil_Nombre|default:''}"  class="form-control" id="Nil_Nombre" name="Nil_Nombre" placeholder="{$ficha[12]['Fie_CampoFicha']}" required/>
                <datalist id="nivel_legal">
                  {foreach item=datos from=$Nil_IdNivelLegal}
                          <option value="{$datos.Nil_Nombre}">
                  {/foreach}    
                </datalist>
            </div>
        </div>
        <div class="form-group">
            <label for="sub_nivel_legal" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']} (*)</label>
            <div class="col-md-6">
                <input type='hidden' value="{$datos1.Snl_IdSubNivelLegal|default:''}" id="Snl_IdSubNivelLegal" name="Snl_IdSubNivelLegal" />
                <input type="text" list="sub_nivel_legal" value="{$datos1.Snl_Nombre|default:''}"  class="form-control" id="Snl_Nombre" name="Snl_Nombre" 
                     placeholder="{$ficha[11]['Fie_CampoFicha']}" required>
                <datalist id="sub_nivel_legal">
                    {foreach item=datos from=$Snl_IdSubNivelLegal}
                            <option value="{$datos.Snl_Nombre}">
                    {/foreach}
                </datalist>  
            </div>
        </div>
        <div class="form-group">
            <label for="tema_legislacion" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']} (*)</label>
            <div class="col-md-6">
                <input type="hidden" value="{$datos1.Tel_IdTemaLegal|default:''}"  id="Tel_IdTemaLegal" name="Tel_IdTemaLegal" />
                <input type="text" list="tema_legal" value="{$datos1.Tel_Nombre|default:''}"  class="form-control" id="Tel_Nombre" name="Tel_Nombre" 
                      placeholder="{$ficha[10]['Fie_CampoFicha']}" required>
                <datalist id="tema_legal">
                    {foreach item=datos from=$Tel_IdTemaLegal}
                        <option value="{$datos.Tel_Nombre}">
                    {/foreach}   
                </datalist>
            </div>
        </div>      
        <div class="form-group">
            <label for="fecha_publicacion" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']}</label>
            <div class="col-md-3">
                <input type="date" value="{$datos1.Mal_FechaPublicacion|default:''}" class="form-control" id="Mal_FechaPublicacion" name="Mal_FechaPublicacion"
                     placeholder="{$ficha[0]['Fie_CampoFicha']}" >
            </div>
        </div>
        <div class="form-group">
            <label for="entidad" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']}</label>
            <div class="col-md-6">
                <input type="text" value="{$datos1.Mal_Entidad|default:''}" class="form-control" id="Mal_Entidad" name="Mal_Entidad" 
                     placeholder="{$ficha[1]['Fie_CampoFicha']}">
            </div>
        </div>
        <div class="form-group">
            <label for="numero_normas" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']}</label>
            <div class="col-md-6">
                <input type="text" value="{$datos1.Mal_NumeroNormas|default:''}" class="form-control" id="Mal_NumeroNormas" name="Mal_NumeroNormas"
                     placeholder="{$ficha[2]['Fie_CampoFicha']}">
            </div>
        </div>
        <div class="form-group">
            <label for="titulo" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']} (*)</label>
            <div class="col-md-6">
                <input type="text" value="{$datos1.Mal_Titulo|default:''}" class="form-control" id="Mal_Titulo" name="Mal_Titulo"
                     placeholder="{$ficha[3]['Fie_CampoFicha']}" required>
            </div>
        </div>
        <div class="form-group">
            <label for="articulos_aplicables" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']}</label>
            <div class="col-md-6">
                <input type="text" value="{$datos1.Mal_ArticuloAplicable|default:''}" class="form-control" id="Mal_ArticuloAplicable" name="Mal_ArticuloAplicable" 
                     placeholder="{$ficha[4]['Fie_CampoFicha']}">
            </div>
        </div>
        <div class="form-group">
            <label for="resumen_legislacion" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']}</label>
            <div class="col-md-6">
                <textarea class="form-control" rows="3" id="Mal_ResumenLegislacion" name="Mal_ResumenLegislacion" placeholder="{$ficha[5]['Fie_CampoFicha']}">{$datos1.Mal_ResumenLegislacion|default:''}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="fecha_revision" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']}</label>
            <div class="col-md-3">
                <input type="date" value="{$datos1.Mal_FechaRevision|default:''}" class="form-control" id="Mal_FechaRevision" name="Mal_FechaRevision" 
                     placeholder="{$ficha[6]['Fie_CampoFicha']}">
            </div>
        </div>
        <div class="form-group">
            <label for="normas_complementarias" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']}</label>
            <div class="col-md-6">
                <input type="text" value="{$datos1.Mal_NormasComplemaentarias|default:''}" class="form-control" id="Mal_NormasComplemaentarias" name="Mal_NormasComplemaentarias"
                     placeholder="{$ficha[7]['Fie_CampoFicha']}">
            </div>
        </div>                    
        <div class="form-group">
            <label for="tipo_legislacion" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']} (*)</label>
            <div class="col-md-6">
                <input type="hidden" value="{$datos1.Til_IdTipoLegal|default:''}" id="Til_IdTipolegal" name="Til_IdTipolegal" />
                <input type="text" list="tipo_legislacion" value="{$datos1.Til_Nombre|default:''}"  class="form-control" id="Til_Nombre" name="Til_Nombre" 
                     placeholder="{$ficha[8]['Fie_CampoFicha']}" required>
                <datalist id="tipo_legislacion">
                    {foreach item=datos from=$Til_IdTipoLegal}
                            <option value="{$datos.Til_Nombre}">
                    {/foreach}
                </datalist>  
            </div>
        </div>
        <div class="form-group">
            <label for="palabra_clave" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
            <div class="col-md-6">
                <input type="text" value="{$datos1.Mal_PalabraClave|default:''}" list="palabra_clave" class="form-control" id="Mal_PalabraClave" name="Mal_PalabraClave"
                     placeholder="{$ficha[13]['Fie_CampoFicha']}" >
                <!--<datalist id="palabra_clave">
                    {foreach item=datos from=$Mal_PalabraClave}
                            <option value="{$datos.Mal_PalabraClave}">
                    {/foreach}   
                </datalist>-->
            </div>
        </div>
        <div class="form-group">
            <label for="pais" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']} (*)</label>
            <div class="col-md-3">
                <select class="form-control" id="Pai_IdPais" name="Pai_IdPais" required>
                    <option value="">Seleccione Pais</option>
                    {foreach from=$paises item=ps}
                        <option value="{$ps.Pai_IdPais}" {if $datos1.Pai_IdPais == $ps.Pai_IdPais} selected="selected" {/if}>{$ps.Pai_Nombre}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-4 col-md-6">
                <button type="submit" class="btn btn-primary" id="btnEditarLegal" name='btnEditarLegal'>Actualizar</button>
            </div>
        </div>
    </div> 
</div>