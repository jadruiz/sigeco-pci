function clearFilters(table) {
  $("#filter-dt-length").val(10);
  $(
    '#form-filter .tab-pane input[type="text"], #form-filter .tab-pane select, #global-search'
  ).val("");
  $("#form-filter .tab-pane input.range-min").val(function () {
    return $(this).attr("min");
  });
  $("#form-filter .tab-pane input.range-max").val(function () {
    return $(this).attr("max");
  });
  table.search("").columns().search("").draw();
}

function initInputFormFilterActions(table) {
  $("#form-filter .tab-pane select").change(function () {
    filterCol($(this).data("column-id"), $(this).val(), table);
  });

  var debounceTimer;
  $("#form-filter .tab-pane .range-min, #form-filter .tab-pane .range-max").on(
    "input",
    function () {
      const columnId = $(this).data("column-id");
      const min = $('.range-min[data-column-id="' + columnId + '"]').val();
      const max = $('.range-max[data-column-id="' + columnId + '"]').val();

      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(function () {
        if (min && max) {
          filterColRegex(columnId, min + "<=>" + max, table);
        }
      }, 500); // Debouncing con 500 ms de retardo
    }
  );
}

function filterCol(column_number, value, table) {
  table.column(column_number).search(value).draw();
}

function filterColRegex(column_number, regex, table) {
  table.column(column_number).search(regex, true, false).draw();
}

function handleGlobalSearch(value, table) {
  if (value.length >= 3 || value.length === 0) {
    $("#dt-search-0").val(value).trigger("keyup");
    if (value.length === 0) {
      table.search("").draw();
    }
  }
}
