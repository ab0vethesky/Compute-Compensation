
$(document).ready(function()
{
 $('#upload_csv').on('submit', function(event)
 {
  event.preventDefault();
  $.ajax({
   url:"import.php",
   method:"POST",
   data:new FormData(this),
   dataType:'json',
   contentType:false,
   cache:false,
   processData:false,
   success:function(jsonData)
   {
    $('#csv_file').val('');
    $('#data-table').DataTable({
     data  :  jsonData,
     columns :  [
      { data : "employee_id" },
      { data : "employee_name" },
      { data : "transport_type" },
      { data : "distance_amt" },
      { data : "workdays_amt" },
      { data : "compensation_amt"},
      { data : "payment_date"}   
     ]
    });
   }
  });
 });
});