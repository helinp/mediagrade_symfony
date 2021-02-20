var groupColumns = [0, 1];

var table = $("#projects-list-table").DataTable({
  order: [
    [0, "asc"],
    [1, "desc"],
    [4, "desc"],
  ],
  ordering: false,
  paging: false,
  rowGroup: {
    dataSrc: groupColumns,
  },
  lengthChange: false,
  columnDefs: [
    { 
      targets: groupColumns,
      visible: false
      }
  ],
  stateSave: true,
  stateDuration: -1,
  pageLength: -1,
  responsive: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/French.json",
  },
  field: {
    className: "form-control bg-light border-0 small",
  },
});
