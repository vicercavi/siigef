$(document).on('ready', function () {     
   
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'estandar/registros/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    $("body").on('click', ".idioma_s", function () {
        var id = $(this).attr("id");
        var idIdiomaSlect = $("#hd_" + id).val();
        gestionIdiomas($("#Rec_IdRecurso").val(), $("#Reg_IdRegistro").val(), idIdiomaSlect);
    });
    $("body").on('click', ".cb_texto_editor", function (e) {
        var id = $(this).attr("id").split('-')[1];
         if(e.target.checked){
             //$("."+id+"-textarea").val($("."+id+"-text").val());
             // $("."+id+"-textarea").html($("."+id+"-text").val());
            //$("."+id+"-textarea" ).removeClass( "hide" );
            //$("."+id+"-text").addClass( "hide" );
            $("."+id+"-tex").addClass("ckeditor");
            $("."+id+"-text").ckeditor();
            
         }else{            
              $("."+id+"-text").val($("."+id+"-textarea").val());
              $("."+id+"-textarea").html($("."+id+"-textarea").val());
            $("."+id+"-textarea" ).addClass( "hide" );
            $("."+id+"-text").removeClass( "hide" );
            $("."+id+"-textarea").removeClass("ckeditor");
            $("."+id+"-textarea").val($("."+id+"-textarea").html());
            CKEDITOR.instances[id].destroy();
         }
          //CKEDITOR.replace( id );
        //CKEDITOR.instances.editor1.destroy();
        
        
    });
    /*
    $("body").on('click', "#buscar", function () {
        buscar($("#palabra").val());
    });*/
    
});
function buscar(criterio) {
    $.post(_root_ + 'usuarios/index/_buscarUsuario',
    {
        palabra:criterio
        
    }, function (data) {
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}

function gestionIdiomas(Rec_IdRecurso,Reg_IdRegistro, idIdiomaSlect) {
    $.post(_root_ + 'estandar/registros/gestion_idiomas',
            {
                Rec_IdRecurso:Rec_IdRecurso,                
                Reg_IdRegistro: Reg_IdRegistro,
                idIdiomaSlect: idIdiomaSlect
            }, function (data) {
        $("#gestion_idiomas").html('');
        $("#gestion_idiomas").html(data);
        $('form').validator();
    });
}