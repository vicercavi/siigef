
$(document).on('ready', function () {        
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'estandar/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    $("body").on('change', "#Fie_TipoDatoCampo", function () {        
        if($("#Fie_TipoDatoCampo").val()=="Decimal"){     
            document.form1.Fie_TamanoColumna.value = "16,8";
            document.form1.Fie_TamanoColumna.disabled = true;
        }
        if($("#Fie_TipoDatoCampo").val()=="Entero"){     
            document.form1.Fie_TamanoColumna.value = 10;
            document.form1.Fie_TamanoColumna.disabled = true;
        }
        if($("#Fie_TipoDatoCampo").val()=="Latitud"){     
            document.form1.Fie_TamanoColumna.value = 100;
            document.form1.Fie_TamanoColumna.disabled = true;
        }
        if($("#Fie_TipoDatoCampo").val()=="Longitud"){     
            document.form1.Fie_TamanoColumna.value = 100;
            document.form1.Fie_TamanoColumna.disabled = true;
        }
        if($("#Fie_TipoDatoCampo").val()=="Texto"){     
            document.form1.Fie_TamanoColumna.disabled = false;
            document.form1.Fie_TamanoColumna.value = "";
        }
    });
    
    $("body").on('click', "#buscar", function () {
        buscarEstandar($("#palabra").val());
    });
    $("body").on('click', "#buscarCampo", function () {
        buscarCampo($("#idEstandarRecurso").val(), $("#palabraCampo").val());
    });
    $("body").on('click', '.estado-ficha', function() {
        $("#cargando").show();
        eliminarFicha($("#idEstandarRecurso").val(), $("#palabraCampo").val(), $(this).attr("ficha"));       
    }); 
    $("body").on('click', '.eliminarEstandar', function() {
        $("#cargando").show();
        eliminarEstandar($(this).attr("Esr_IdEstandarRecurso"), $(this).attr("Esr_NombreTabla"));
    });
    $("body").on('click', ".idioma_s", function () {
        $("#cargando").show();
        var id = $(this).attr("id");
        var idIdioma = $("#hd_" + id).val();
        gestionIdiomas( $("#Fie_IdFichaEstandar").val(), $("#idIdiomaOriginal").val(), idIdioma);
    }); 
});
function buscarEstandar(palabra) {
    $.post(_root_ + 'estandar/index/_buscarEstandar',
    {
        palabra:palabra
        
    }, function (data) {
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}
function buscarCampo(idEstandarRecurso, palabraCampo) {
    $.post(_root_ + 'estandar/index/_buscarCampo',
    {
        idEstandarRecurso:idEstandarRecurso,
        palabra:palabraCampo        
    }, function (data) {
        $("#listaregistrosFichas").html('');
        $("#listaregistrosFichas").html(data);
    });
}
function eliminarFicha(idEstandarRecurso, palabraCampo, idficha) {
    $.post(_root_ + 'estandar/index/_eliminarFicha',
    {
        idEstandarRecurso:idEstandarRecurso,
        palabra:palabraCampo,
        idficha:idficha
        
    }, function (data) {
        $("#cargando").hide();
        $("#listaregistrosFichas").html('');
        $("#listaregistrosFichas").html(data);
    });
}
function eliminarEstandar(Esr_IdEstandarRecurso, Esr_NombreTabla) {
    $.post(_root_ + 'estandar/index/_eliminarEstandar',
    {
        Esr_IdEstandarRecurso:Esr_IdEstandarRecurso,
        Esr_NombreTabla:Esr_NombreTabla        
    }, function (data) {
        $("#cargando").hide();
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}
function gestionIdiomas(Fie_IdFichaEstandar, idIdiomaOriginal, idIdioma) {
    $.post(_root_ + 'estandar/index/gestion_idiomas_ficha',
            {
                Fie_IdFichaEstandar:Fie_IdFichaEstandar,
                idIdioma: idIdioma,
                idIdiomaOriginal: idIdiomaOriginal
            }, function (data) {
        $("#gestion_idiomas_ficha").html('');
        $("#cargando").hide();
        $("#gestion_idiomas_ficha").html(data);
        $('form').validator();
    });
}