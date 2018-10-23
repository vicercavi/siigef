<h2 align="center">Detalle de Documento</h2>
{foreach item=datos from=$detalle}
<table class="table table-bordered table-condensed table-striped">
<tr><th>Tipo Archivo</th> <th><img src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png" pais="{$datos.Taf_Descripcion}"/></th></tr>
<tr><th>Editor</th><th>{$datos.Dub_Editor}</th></tr>
<tr><th>Colaborador</th><th>{$datos.Dub_Colaborador}</th></tr>
<tr><th>Fecha de Documento</th><th>{$datos.Dub_FechaDocumento}</th></tr>
<tr><th>Formato</th><th>{$datos.Dub_Formato}</th></tr>
<tr><th>Fuente</th><th>{$datos.Dub_Fuente}</th></tr>
<tr><th>Idioma</th><th>{$datos.Dub_Idioma}</th></tr>
<tr><th>Relacion</th><th>{$datos.Dub_Relacion}</th></tr>
<tr><th>Cobertura</th><th>{$datos.Dub_Cobertura}</th></tr>
<tr><th>Derechos</th><th>{$datos.Dub_Derechos}</th></tr>
<tr><th>Palabra Clave</th><th>{$datos.Dub_PalabraClave}</th></tr>
<tr><th>Tipo </th><th>{$datos.Tid_Descripcion}</th></tr>
<tr><th>Titulo </th><th>{$datos.Dub_Titulo}</th></tr>
<tr><th>Autor </th><th>{$datos.Aut_Nombre}</th></tr>
<tr><th>Tema </th><th>{$datos.Ted_Descripcion}</th></tr>
<tr><th>Tipo Archivo Fisico</th><th>{$datos.Taf_Descripcion}</th></tr>
<tr><th>Archivo Tipo</th><th>{$datos.Arf_Tipo}</th></tr>
<tr><th>Tamaño de Archivo  </th><th>{$datos.Arf_TamanoArchivo} bytes</th></tr>
<tr><th>Descripcion </th><th>{$datos.Dub_Descripcion}</th></tr>

</table>                      
{/foreach}


<input type='button' value='Atras' onClick='history.go(-1);'>