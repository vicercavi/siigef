{foreach item=datos from=$detalle}
<ul>
<li style="display:inline"><span class="metodo" metodo="registroIndividual" ajax="#registo_individual" estandar="{$datos.Est_IdEstandar}"><a style="cursor:pointer">Registrar Datos Individualmente</a></span></li>
<li style="display:inline"><span class="fromulario" fromulario="registroIndividual" ajax="#registo_individual"><a style="cursor:pointer">Cargar Datos desde Archivo</a></span></li>
<li style="display:inline"><span class="fromulario" fromulario="registroIndividual" ajax="#registo_individual"><a style="cursor:pointer">Cargar Datos desde Interoperabilidad</a></span></li>
</ul>
	
  
<table class="table table-bordered table-condensed table-striped" >

                <tr>
                    
                    <th>Nombre</th>
                    <th>Fuente</th>
                    <th>Tipo de Recurso</th>
                    <th>Total de Registros</th>
                    <th>Fecha de Registro</th>
                    <th>Origen de Recurso</th>
                    <th>Estandar Utilizado</th>
                    <th>Servicio que lo Consume</th>
                    <th>Última Modificación</th>
                    
                                        
                </tr>
                
                
                	
                    <tr>                       
                        
                        <td>{$datos.Rec_Nombre}</td>
                        <td><h5>{$datos.Rec_Fuente}</h5></td>
                        <td>{$datos.Tir_Nombre}</td>
                        <td>{$datos.Rec_CantidadRegistros}</td>
                        <td>{$datos.Rec_FechaRegistro}</td>
                        <td>{$datos.Rec_Origen}</td>
                        <td>{$datos.Est_Nombre}</td>
                        <td>{$datos.Ses_Nombre}</td>
                        <td>{$datos.Rec_UltimaModificacion}</td>
                        
                    </tr>                     
                {/foreach}
            </table>


<div id="registo_individual">
    	
    </div>