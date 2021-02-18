//
// TOOLTIPS
//

$(document).ready(function () {
  $("body").tooltip({ selector: "[data-toggle=tooltip]" });
});

//
// DYNAMIC SELECT
//

// SCHOOLYEAR
$("#school_years_schoolYear").change(function () {
  params.set("school_year", $(this).val());
  window.location.href = "?" + params.toString();
});

// TERM
$("#terms_id").change(function () {
  // set the window's location property to the value of the option the user has selected
  url = window.location.href;
  const pathArray = url.split("/");

  if (typeof pathArray[6] !== "undefined") {
    parts = url.split("/");
    parts.pop();
    url = parts.join("/");
  }
  window.location = url + "/" + $(this).val();
});

// COURSE
$("#courses_topbar_id").change(function () {
  // set the window's location property to the value of the option the user has selected
  url = window.location.href;

  const pathArray = url.split("/");

  if (typeof pathArray[6] !== "undefined") {
    parts = url.split("/");
    parts.pop();
    url = parts.join("/");
  }
  if (typeof pathArray[5] !== "undefined") {
    parts = url.split("/");
    parts.pop();
    url = parts.join("/");
  }
  if (typeof pathArray[6] !== "undefined") {
    window.location = url + "/" + $(this).val() + "/" + pathArray[6];
  } else {
    window.location = url + "/" + $(this).val();
  }
});

var table = $("#table-gradebook").DataTable({
  lengthChange: false,
  paging: false,
  language: {
    url:
      "{{ asset('//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json') }}",
  },
  field: {
    className: "form-control bg-light border-0 small",
  },
  scrollX: true,
  scrollCollapse: false,
  fixedColumns: {
    leftColumns: 1,
  },
  dom: "Bfrtip",
  buttons: ["excel", "pdf"],

  buttons: [
    {
      extend: "print",
      className: "ml-4 btn-sm btn-info",
      text: '<i class="fas fa-print"></i> Vue d\'impression',
      orientation: "landscape",
      autoPrint: false,
    },
    {
      extend: "excel",
      className: "ml-2 btn-sm btn-info",
      text: '<i class="far fa-file-excel"></i> Excel',
      orientation: "landscape",
      autoPrint: false,
    },
  ],
});
