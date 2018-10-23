<div class="pf-container">    
    <div class="pf-title">
        <label> 

            Nombre Cientifico:
            <a data-toggle="tooltip"  target='_blank' data-placement="bottom" class="link-home" title=""  target="_blank">
                {$especie.Dar_NombreCientifico}
            </a>      

                <small style=" width: auto;  margin: 0px 0 0 5px;   display: inline;"> <a  title="Ver Fotos"  href="https://www.bing.com/images/search?q={$especie.Dar_NombreCientifico}&FORM=AWIR" target="_blank"><i class="icon-share"></i>Ver Fotos Bing</a></small>
        </label>  


    </div>
    <div class="pf-content">  
        <table class="table table-user-information">
            <tbody>
                <tr>
                    <td>Reino</td>
                    <td>{$especie.Dar_ReinoOrganismo}</td>
                </tr>
                <tr>
                    <td>Clase</td>
                    <td>{$especie.Dar_ClaseOrganismo}</td>
                </tr>
                <tr>
                    <td>Orden</td>
                    <td>{$especie.Dar_OrdenOrganismo}</td>
                </tr>
                <tr>
                    <td>Familia</td>
                    <td>{$especie.Dar_FamiliaOrganismo}</td>
                </tr>
                <tr>
                    <td>Nombre Común</td>
                    <td>{$especie.Dar_NombreComunOrganismo}</td>
                </tr>
                <tr>
                    <td>Codigo de la Institución</td>
                    <td>{$especie.Dar_CodigoInstitucion}</td>
                </tr>
                <tr>
                    <td>Latitud</td>
                    <td>{$especie.Dar_Latitud}</td>
                </tr>                                
                <tr>
                    <td>Longitud</td>
                    <td>{$especie.Dar_Longitud}</td>
                </tr>
                <tr>
                    <td>Pais</td>
                    <td>{$especie.Dar_Pais}</td>
                </tr>
                <tr>
                    <td>Estado/Provincia</td>
                    <td>{$especie.Dar_EstadoProvincia}</td>
                </tr>
                <tr>
                    <td>Municipio</td>
                    <td>
                        {$especie.Dar_Municipio}
                    </td>
                </tr>
                <tr>
                    <td>Colector</td>
                    <td>{$especie.Dar_Colector}</td>
                </tr>  
             
                <tr>
                    <td>Año Colectado</td>
                    <td>{$especie.Dar_AnoColectado}</td>
                </tr> 
                <tr>
                    <td>Mes Colectado</td>
                    <td>{$especie.Dar_MesColectado}</td>
                </tr> 
                <tr>
                    <td>Día Colectado</td>
                    <td>{$especie.Dar_DiaColectado}</td>
                </tr>
            </tbody>
        </table>
    </div>     
</div>

