<?php
//index.php
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Compute Compensation</title>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

 </head>
  <style>
    .box
    {
    max-width:600px;
    width:100%;
    margin: 0 auto;;
    }
  </style>
 </head>
 <body>
  <div class="container">
   <br />
   <h3 align="center">Compute Employee Transport Compensation</h3>
   <br />
   <form id="upload_csv" method="post" enctype="multipart/form-data">
    <div class="col-md-3">
     <br />
     <label>Import CSV file with the headers below to compute</label>
    </div>  
    <div class="col-md-4">  
        <input type="file" name="csv_file" id="csv_file" accept=".csv" style="margin-top:15px;" />
    </div>  
    <div class="col-md-5">  
        <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-success" />
    </div>  
    <div style="clear:both"></div>
   </form>
   <br />
   <br />
   <div class="table-responsive">
    <table class="table table-striped table-bordered" id="data-table">
     <thead>
      <tr>
       <th>Employee ID</th>
       <th>Employee Name</th>
       <th>Transport Type</th>
       <th>Distance (km)</th>
       <th>Workdays</th>
       <th>Compensation (€)</th>
      </tr>
     </thead>
    </table>

    <button onclick="exportTableToExcel('data-table', 'computed-data')" class="btn btn-primary">Export Table To Excel File</button>

   </div>
  </div>
 </body>
</html>

<script>

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
      { data : "compensation_amt"}   
     ]
    });
   }
  });
 });
});
</script>

<script>
function exportTableToExcel(tableID, filename = '')
{
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob)
    {
        var blob = new Blob(['\ufeff', tableHTML], 
        {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>