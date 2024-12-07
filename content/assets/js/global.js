function _redirect(url) {
  window.location.href = baseUrl + url;
}

function ajaxBase({
  url,
  method = "POST",
  data = {},
  successCallback,
  errorCallback,
  redirectExpiredSess,
}) {
  data[csrfTokenName] = csrfToken;
  $.ajax({
    url: baseUrl + url,
    type: method,
    dataType: "json",
    data: {
      ...data,
    },
    success: function (response) {
      if (successCallback && typeof successCallback === "function") {
        successCallback(response);
      }
    },
    error: function (xhr) {
      if (
        xhr.status === 401 &&
        xhr.responseJSON &&
        xhr.responseJSON.status === "session_expired"
      ) {
        if (typeof redirectExpiredSess !== "undefined" && redirectExpiredSess) {
          _redirect(redirectExpiredSess);
        } else {
          _redirect(typeof baseUrl !== "undefined" && baseUrl ? baseUrl : "/");
        }
      } else {
        console.error("Error en la solicitud AJAX:", xhr.responseText);
        if (errorCallback && typeof errorCallback === "function") {
          errorCallback(xhr);
        } else {
          alert("Hubo un problema con la solicitud.");
        }
      }
    },
  });
}

function createModal({
  id = "genericModal",
  title = "Modal Title",
  body = "Modal Content",
  buttons = [],
}) {
  $(`#${id}`).remove();
  const modalHTML = `
      <div class="modal fade" id="${id}" tabindex="-1" aria-labelledby="${id}Label" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="${id}Label">${title}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      ${body}
                  </div>
                  <div class="modal-footer">
                      ${buttons
                        .map(
                          (button, index) => `
                          <button type="button" 
                                  class="btn ${
                                    button.class || "btn-secondary"
                                  }" 
                                  id="${id}-btn-${index}">
                              ${button.text}
                          </button>
                      `
                        )
                        .join("")}
                  </div>
              </div>
          </div>
      </div>
  `;
  // Agregar el modal al DOM
  $("body").append(modalHTML);
  // Asignar eventos a los botones
  buttons.forEach((button, index) => {
    $(`#${id}-btn-${index}`).on("click", button.action);
  });
  // Mostrar el modal
  $(`#${id}`).modal("show");
}
