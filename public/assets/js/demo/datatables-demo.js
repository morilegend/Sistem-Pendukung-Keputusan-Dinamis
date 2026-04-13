$(document).ready(function () {
  $('#dataTable').DataTable({
    "searching": false,  // Menonaktifkan search box
    "paging": true,
    "ordering": true,
    "info": false
  });
});