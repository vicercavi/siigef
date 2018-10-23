$(document).ready(function () {
    $('#Dub_FechaDocumento').datepicker({
        format: "dd/mm/yyyy"
    });

    var validator = $("#editardublin").bootstrapValidator({
        feedbackIcons: {
            valid: "glyphicon glyphicon-ok",
            invalid: "glyphicon glyphicon-remove",
            validating: "glyphicon glyphicon-refresh"
        },
        fields: {
            Dub_Titulo: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Dub_Descripcion: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Aut_IdAutor: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Dub_Formato: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Idi_IdIdioma: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Dub_PalabraClave: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Tid_IdTipoDublin: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },
            Ted_IdTemaDublin: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            },            
            Pai_IdPais: {
                validators: {
                    notEmpty: {
                        message: "El campo es requerido"
                    }
                }
            }
        }
    });

    $("body").on('click', ".idioma_s", function () {
        var id = $(this).attr("id");
        var idIdioma = $("#hd_" + id).val();
        gestionIdiomas($("#Dub_IdDublinCore").val(), $("#Idi_IdIdiomaOriginal").val(), idIdioma);
    });
});

function gestionIdiomas(idDublin, idIdiomaOriginal, idIdioma) {
    $("#cargando").show();
    $.post(_root_ + 'dublincore/editar/gestion_idiomas',
            {
                idIdioma: idIdioma,
                idDublin: idDublin,
                idIdiomaOriginal: idIdiomaOriginal
            }, function (data) {
        $("#cargando").hide();
        $("#gestion_idiomas").html('');
        $("#gestion_idiomas").html(data);
    });
}