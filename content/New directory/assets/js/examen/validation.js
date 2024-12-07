$(document).ready(function () {
  let hayCambios = false;
  const estadoInicial = $("#frm-preguntas-seccion").serialize();

  // Detectar cambios en el formulario
  $(
    '#frm-preguntas-seccion input[type="radio"], #frm-preguntas-seccion textarea, #frm-preguntas-seccion select'
  ).on("change", function () {
    hayCambios = true;
  });

  // Validación antes de enviar
  $("#btn-submit").on("click", function (event) {
    event.preventDefault();
    let haySinContestar = false;

    $('#frm-preguntas-seccion input[type="radio"]').each(function () {
      let name = $(this).attr("name");
      if (!$('input[name="' + name + '"]:checked').length) {
        haySinContestar = true;
        return false;
      }
    });

    $("#frm-preguntas-seccion textarea").each(function () {
      if ($(this).val().trim() === "") {
        haySinContestar = true;
        return false;
      }
    });

    $("#frm-preguntas-seccion select").each(function () {
      if ($(this).val() === "") {
        haySinContestar = true;
        return false;
      }
    });

    $('#frm-preguntas-seccion input[type="file"]').each(function () {
      if ($(this).attr("name").startsWith("pregunta_") && !this.files.length) {
        haySinContestar = true;
        return false;
      }
    });

    if (haySinContestar) {
      $("#confirmModal").modal("show");
    } else {
      $("#frm-preguntas-seccion").off("submit").submit();
    }
  });

  $("#confirmContinue").on("click", function () {
    $("#confirmModal").modal("hide");
    $("#frm-preguntas-seccion").off("submit").submit();
  });

  $("#btn-previous").on("click", function (e) {
    e.preventDefault();
    const urlAnterior = $(this).data("url");

    if (
      hayCambios ||
      $("#frm-preguntas-seccion").serialize() !== estadoInicial
    ) {
      $("#frm-preguntas-seccion").off("submit").submit();
    } else {
      window.location.href = urlAnterior;
    }
  });
});
