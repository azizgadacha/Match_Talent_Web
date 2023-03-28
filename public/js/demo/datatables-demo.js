// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});
$(document).ready(function () {
  $('#dataTable').DataTable({
      pagingType: 'full_numbers',
  });
});