$(document).ready(function () {
  let hayCambios = false;
  const estadoInicial = $("#frm-preguntas-seccion").serialize();

  $(
    '#frm-preguntas-seccion input[type="radio"], #frm-preguntas-seccion textarea, #frm-preguntas-seccion select'
  ).on("change", function () {
    hayCambios = true;
  });

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
  const $stickyElement = $('#sticky-element');
  const $parentColumn = $stickyElement.parent();
  let offsetTop = $parentColumn.offset().top;
  let stickyApplied = false;

  // Función para ajustar el ancho del elemento sticky basado en la columna
  function adjustStickyWidth() {
      $stickyElement.css('width', $parentColumn.width());
  }

  // Ajusta el ancho al cargar la página
  adjustStickyWidth();

  // Función para manejar el scroll y aplicar posición fija
  function handleScroll() {
      if ($(window).scrollTop() > offsetTop && !stickyApplied) {
          $stickyElement.addClass('sticky-fixed');
          adjustStickyWidth(); // Asegura que el ancho se mantenga al hacer scroll
          stickyApplied = true;
      } else if ($(window).scrollTop() <= offsetTop && stickyApplied) {
          $stickyElement.removeClass('sticky-fixed');
          $stickyElement.css('width', '100%'); // Restablece el ancho relativo cuando no es fijo
          stickyApplied = false;
      }
  }

  // Escucha el evento de scroll para activar posición fija
  $(window).on('scroll', handleScroll);

  // Reajusta el ancho y la posición al cambiar el tamaño de la ventana
  $(window).on('resize', function() {
      offsetTop = $parentColumn.offset().top; // Recalcula el offset
      adjustStickyWidth(); // Recalcula el ancho al cambiar tamaño de la ventana
      handleScroll(); // Asegura que el estado sticky esté actualizado después del resize
  });
});
