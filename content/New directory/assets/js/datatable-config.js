function initModuleDatatable({
  tableId,
  ajaxUrl,
  columns,
  language,
  columnDefs,
  extraOptions,
}) {
  // Configuración base de DataTables
  const defaultOptions = {
    processing: true,
    serverSide: true,
    scrollX: true,
    autoWidth: true,
    ajax: {
      url: ajaxUrl,
      type: "POST",
      dataSrc: function (json) {
        if (json.status === "session_expired") {
          window.location.href = baseUrl + "admin/login";
          return [];
        }
        return json.data || [];
      },
      error: function (xhr, error, thrown) {
        if (xhr.status === 401) {
          window.location.href = baseUrl + "admin/login";
        } else {
          console.error("Error en la respuesta AJAX:", thrown);
          alert(
            "Ocurrió un error al cargar los datos. Por favor, recarga la página."
          );
        }
      },
    },
    columns: columns,
    language: language || {
      url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json",
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    columnDefs: columnDefs || [],
  };

  // Combina opciones predeterminadas con las opciones específicas del módulo
  const options = { ...defaultOptions, ...extraOptions };
  return $(tableId).DataTable(options);
}

// Herramientas de filtro para longitud y reinicio
function initFilterToolsBar(table) {
  const filterTools = $("<div>", { class: "filter-tools" }).append(
    $("<div>", { class: "input-group" }).append(
      $("<span>", { class: "input-group-text" }).text("Ver"),
      $("<select>", { id: "filter-dt-length", class: "form-select" }).append(
        [5, 10, 25, 50, 100, 200, 500].map((num) =>
          $("<option>", { value: num, text: num }).prop("selected", num === 10)
        )
      ),
      $("<span>", { class: "input-group-text" }).text("registros")
    ),
    $("<button>", {
      type: "button",
      class: "btn btn-warning ms-2",
      id: "clear-filters",
      text: "Quitar Filtros",
    }).on("click", function () {
      clearFilters(table);
    })
  );

  $("#form-filter .container:first-child").prepend(filterTools);
  $("#filter-dt-length").on("change", function () {
    table.page.len($(this).val()).draw();
  });
}

// Función de búsqueda global
function handleGlobalSearch(searchValue, table) {
  table.search(searchValue).draw();
}

function cargarOpcionesCarreras(modalidad, campus, division) {
  ajaxBase({
    url: "admin/obtener-opciones-carreras",
    data: {
      modalidad: modalidad,
      campus: campus,
      division: division,
    },
    successCallback: function (data) {
      $("#id_carrera").empty().append('<option value="">Todas</option>');
      $.each(data, function (index, carrera) {
        $("#id_carrera").append(new Option(carrera.nombre, carrera.id));
      });
    },
    errorCallback: function (xhr) {
      console.error("Error al cargar carreras:", xhr.responseText);
    },
  });
}
