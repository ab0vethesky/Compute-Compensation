# Compute-Compensation

To run the application, simply unzip the folder into your php web server's root folder. If you are using XAMPP, unzip the folder to the 'htdocs' fodler and access via 
the url - localhost/Compute-Compensation/index.php (or localhost:{your port number}/Compute-Compensation/index.php .

To generate the computation, first prepare a CSV file with the following headers (employee_id, employee_name, transport_type, distance_amt, workdays_amt) and save in the 
Compute-Compensaion folder. 

After importing the file, click on the button "Upload" and a table is generated showing an additional column for the required compensation amount. A button is provided
at the bottom of the table "Export Table to Excel File" which exports the displayed table on the page to an excel file.

Funcions

import.php - Does the file import processing.

    function computeamt - Takes values from the imported csv file and computes the compensation based on the values returned from the api.

Views

index.php - Renders the imported csv file as a DataTable including the additional columns for payment date and compensation amount. 

export.js

    function exportTableToExcel - JavaScript function that prepares the rendererd table as an excel file to be downloaded by the user.


