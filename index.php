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

  <script type="text/javascript" src="export.js"></script>
  <script src="dtable.js"></script>
  <link rel="stylesheet" href="styles.css">

 </head>
 <body>
  <div class="container">
   <br />
   <h3 align="center">Compute Employee Transport Compensation</h3>
   <br />
   <form id="upload_csv" method="post" enctype="multipart/form-data">
    <div class="col-md-3">
     <br />
     <label>Import CSV file to compute compensation.</label>
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
       <th>**Compensation (€)</th>
       <th>Payment Date</th>
      </tr>
     </thead>
    </table>

    <button onclick="exportTableToExcel('data-table', 'computed-data'+Date.now())" class="btn btn-primary">Export Table To Excel File</button>
   </div>
   <div>
       -
   </div>
   <div>
       <b>** Compensation = (Distance * 2) * (Base Compensation per km * {exception factor}) * (Workdays * 4)</b>
   </div>
  </div>
 </body>
</html>