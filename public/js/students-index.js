var table = $("#users-table").DataTable({
    lenghtChange: true,
    dom: "Bfrtip",
    pageLength: 16,
    order: [
      [0, "desc"],
      [1, "desc"],
      [2, "asc"],
      [3, "asc"],
      [4, "asc"],
    ],
    buttons: ["copy", "excel"],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/French.json",
    },
    field: {
      className: "form-control bg-light border-0 small",
    },
});

$(":input").on("propertychange input", function () {
  var lastName = $("#new_student_lastName").val();
  var firstName = $("#new_student_firstName").val();
  var userName = firstName + "." + lastName;
  userName = userName.toLowerCase();
  userName = userName.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

  $("#new_student_userName").val(userName);
});

//
// MODAL
//
$("body").on("click", '[data-toggle="modal"]', function () {
  $($(this).data("target") + " .modal-body").load($(this).data("remote"));
});
