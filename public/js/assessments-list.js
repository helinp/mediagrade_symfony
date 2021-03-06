var table = $("table").DataTable({
  initComplete: function () {
    this.api()
      .columns()
      .every(function () {
        var column = this;
        var select = $('<select><option value=""></option></select>')
          .appendTo($(column.header()).empty())
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        column
          .data()
          .unique()
          .sort()
          .each(function (d, j) {
            select.append('<option value="' + d + '">' + d + "</option>");
          });
      });
  },
  order: [
    [0, "desc"],
    [1, "desc"],
    [2, "asc"],
    [3, "asc"],
    [4, "asc"],
  ],
  stateSave: true,
  stateDuration: -1,
  dom: "Bfrtip",
  pageLength: 16,
  responsive: true,
  buttons: ["copy", "excel"],
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/French.json",
  },
  field: {
    className: "form-control bg-light border-0 small",
  },
});
