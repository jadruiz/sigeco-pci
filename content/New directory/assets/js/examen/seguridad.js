$(document).ready(function () {
  // Variables para controlar el estado de advertencia de enfoque y pantalla completa
  let hasWarnedFocus = false;
  let isFullscreen = false;

  // Función para mostrar un modal de advertencia con un mensaje personalizado
  function showModal(message) {
    let existingModal = $("#warningModal");
    if (existingModal.length) {
      existingModal.find(".modal-body").text(message);
      existingModal.modal("show");
      return;
    }

    // Si no existe un modal previo, se crea el modal HTML
    const modalHtml = `
            <div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Advertencia de Seguridad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">${message}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>`;

    // Añade el modal al cuerpo del documento y lo muestra
    $("body").append(modalHtml);
    $("#warningModal").modal("show");
  }

  // Función para activar el modo de pantalla completa
  function enterFullscreen() {
    const elem = document.documentElement;
    if (elem.requestFullscreen) elem.requestFullscreen();
    else if (elem.mozRequestFullScreen) elem.mozRequestFullScreen();
    else if (elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
    else if (elem.msRequestFullscreen) elem.msRequestFullscreen();

    isFullscreen = true; // Marca que el modo de pantalla completa está activo
  }

  // Función para salir del modo de pantalla completa
  function exitFullscreen() {
    if (document.exitFullscreen) document.exitFullscreen();
    else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
    else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
    else if (document.msExitFullscreen) document.msExitFullscreen();

    isFullscreen = false; // Marca que el modo de pantalla completa está inactivo
  }

  // Activa el modo de pantalla completa al inicio
  enterFullscreen();

  // Detecta si el usuario sale de pantalla completa y muestra una advertencia
  $(document).on("fullscreenchange", function () {
    if (!document.fullscreenElement && isFullscreen) {
      showModal("Modo de pantalla completa es requerido para continuar el examen.");
      enterFullscreen(); // Vuelve a activar pantalla completa si el usuario sale de ella
    }
  });

  // Detecta si el usuario intenta usar el botón de retroceso y muestra una advertencia
  window.addEventListener("popstate", function () {
    showModal("Navegación deshabilitada durante el examen.");
    history.pushState(null, document.title, location.href); // Previene la navegación hacia atrás
  });

  // Bloquea el menú contextual (click derecho) y muestra una advertencia
  $(document).on("contextmenu", function (e) {
    e.preventDefault();
    showModal("Función deshabilitada durante el examen.");
  });

  // Previene la selección de texto en la página
  $(document).on("selectstart", function (e) {
    e.preventDefault();
  });

  // Controla el estado de advertencia de enfoque al volver a enfocar la ventana
  $(window).on("focus", function () {
    hasWarnedFocus = false; // Resetea el estado de advertencia cuando se enfoca
  });

  // Detecta si el usuario desvía el enfoque y muestra una advertencia
  $(window).on("blur", function () {
    if (!hasWarnedFocus) {
      hasWarnedFocus = true;
      showModal("Por favor, mantén el enfoque en el examen.");
    }
  });

  // Función para detectar si las herramientas de desarrollador están abiertas
  const checkDevToolsOpen = function () {
    const start = new Date();
    debugger;
    const end = new Date();

    // Si la diferencia de tiempo es grande, es probable que DevTools esté abierta
    if (end - start > 100) { // Ajusta el umbral según la precisión deseada
        showModal("Acceso a herramientas de desarrollador detectado. No está permitido durante el examen.");
    }
};

// Llama a checkDevToolsOpen cada segundo para verificar el estado de DevTools
setInterval(checkDevToolsOpen, 1000);

$(window).on("keydown", function (e) {
  const key = e.key;
  const code = e.code;
  const keyCode = e.keyCode;

  // Bloquea las teclas de navegación
  const navigationKeys = ["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", "Tab"];
  const navigationKeyCodes = [37, 38, 39, 40, 9];

  if (navigationKeys.includes(key) || navigationKeyCodes.includes(keyCode)) {
    e.preventDefault();
    showModal("Navegación bloqueada durante el examen.");
    return;
  }

  // Bloquea F12 (keyCode 123) y combinaciones Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C
  if (key === "F12" || keyCode === 123 || (e.ctrlKey && e.shiftKey && (key === "I" || key === "J" || key === "C"))) {
    e.preventDefault();
    showModal("Acceso a herramientas de desarrollador detectado. No está permitido durante el examen.");
    return;
  }

  // Bloquea Ctrl+R (recargar), Ctrl+N (nueva ventana), y Ctrl+T (nueva pestaña)
  if ((e.ctrlKey && (key === "r" || keyCode === 82)) || (e.ctrlKey && (key === "n" || keyCode === 78)) || (e.ctrlKey && (key === "t" || keyCode === 84))) {
    e.preventDefault();
    showModal("La recarga y la navegación a nuevas ventanas/pestañas están deshabilitadas durante el examen.");
    return;
  }

  // Bloquea Alt+Tab (cambio de aplicación) en sistemas que lo permitan
  if (e.altKey && (key === "Tab" || keyCode === 9)) {
    e.preventDefault();
    showModal("El cambio de aplicación está deshabilitado durante el examen.");
    return;
  }
});
});
