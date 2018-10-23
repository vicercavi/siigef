$(document).ready(function(){
 
    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#archivo")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Nombre de Archivo : "+fileName+", Tamaño : "+fileSize/1000+" KB.</span>");
    });
 
    //al enviar el formulario
    $("body").on('click',"#btnregistrarDoc", function(){
        //información del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
        $.ajax({
            url: _root_ + 'dublincore/registro/registrarDocumento',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Subiendo el documento, por favor espere...</span>");
                showMessage(message)        
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $("<span class='success'>Eldocumento "+data+" ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(fileExtension))
                {                 
                    var mirar =$("<img src='"+_root_archivo_fisico+data+"' />");
                    $(".showImage").html("").show();
                    $(".showImage").html(mirar);
                }
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    });
    
    $("body").on('click',".btnIdiomaMeta", function()
    {
        var variables = '&variables=' +  $("#registrar_nuevo").val();
        var metodo = 'registrarIdioma';
        var as = '.nuevo_dato';
        
        $.post(_root_ + 'dublincore/registro/' + metodo, variables, function(data){
            $(as).html('');
            $(as).html(data);
        });
    });
    
    
    $("body").on('click',".registrar_Idioma", function()
    {
        document.getElementById('registrar').value = 1;   
        var variables = '&variables=' +  $("#registrar").val();
        $.post(_root_ + 'dublincore/registro/registrarIdioma' , variables, function(data){
            $(as).html('');
            $(as).html(data);
        });
    });
    /*
    $("body").on('click',"#registrar_Idioma", function()
    {
        //var variables = '&variables=' +  $("#variable").val();
        var metodo = 'registrarIdioma';
        var as = '#nuevo_idioma';
        
        $.post(_root_ + 'dublincore/registro/' + metodo, false, function(data){
            $(as).html('');
            $(as).html(data);
        });
    });*/
});
 
//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}