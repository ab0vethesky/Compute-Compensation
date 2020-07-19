<?php

if(!empty($_FILES['csv_file']['name']))
{

    $file_data = fopen($_FILES['csv_file']['name'], 'r');
     
    fgetcsv($file_data);

    $today = date("j-n-Y");

    while($row = fgetcsv($file_data))
    {
        $data[] = array(
        'employee_id'  => $row[0],
        'employee_name' => $row[1],
        'transport_type' => $row[2],
        'distance_amt'  => number_format($row[3],2),
        'workdays_amt'  => number_format($row[4],2),
        'compensation_amt' => computeamt($row[2],$row[3],$row[4]),
        'payment_date' => $today
        );
    }
    echo json_encode($data);
}
    function computeamt($transtype, $distval, $wrkday)
    {        
          $content = file_get_contents('https://api.staging.yeshugo.com/applicant/travel_types');

          $result = json_decode($content, true); 
        
        $res = (object)$result;
 
        foreach($res as $obj)
        {
            
            $objid = $obj['id'];

                switch($objid)
                {
                    case 1:
                        $trn = $obj['base_compensation_per_km'];                     
                    break;
                    case 2:                        
                        $car = $obj['base_compensation_per_km'];                      
                    break;
                    case 3:                    
                        $bkamts = $obj['base_compensation_per_km'];                  
                    break;
                    case 4:
                        $bustr = $obj['base_compensation_per_km'];                     
                    break;                                                            
                }
                          
          error_reporting(0);
            switch($transtype)
            {
                case "TRAIN":                
                    $comp = $trn; 
                    $minkm = isset($obj['exceptons']['min_km']);
                    $maxkm = isset($obj['exceptons']['max_km']);
                    $factor = isset($obj['exceptions']['factor']);
                    $wk = $wrkday;
                    $amt = computeExcp($comp,$minkm,$maxkm,$distval,$wk,$factor);
                break;  
                case "CAR": 
                    $comp = $car; 
                    $minkm = isset($obj['exceptons']['min_km']);
                    $maxkm = isset($obj['exceptons']['max_km']);
                    $factor = isset($obj['exceptions']['factor']);
                    $wk = $wrkday;
                    $amt = computeExcp($comp,$minkm,$maxkm,$distval,$wk,$factor);
                break; 
                case "BIKE":
 
                    $comp = $bkamts; 
                    $minkm = isset($obj['exceptons']['min_km']);
                    $maxkm = isset($obj['exceptons']['max_km']);
                    $factor = isset($obj['exceptions']['factor']);
                    $wk = $wrkday;
                    $amt = computeExcp($comp,$minkm,$maxkm,$distval,$wk,$factor);
                                                   
                break;
                
                case "BUS":    
                    
                    $comp = $bustr; 
                    $minkm = isset($obj['exceptons']['min_km']);
                    $maxkm = isset($obj['exceptons']['max_km']);
                    $factor = isset($obj['exceptions']['factor']);
                    $wk = $wrkday;
                    $amt = computeExcp($comp,$minkm,$maxkm,$distval,$wk,$factor);
                    
                break;                                                                       
                default:
                    $amt = 0 ;
                break;

                
            }   
                                               
        }                    
       
        return number_format(($amt * 4),2);
    }

    
    function computeExcp($comp,$minkm, $maxkm,$distval,$wk,$factor)
    {
        if (($distval >= $minkm) && ($distval <= $maxkm))   
        {
           
            $amtt = $comp * $factor * $distval * $wk * 2;
        }
        else
        {
            $amtt = $comp * $distval * $wk * 2;
        } 
        return $amtt;

    }

?>