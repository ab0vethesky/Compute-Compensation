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

        //$name = $res->name;
/*
        $bkamt = 0.33;
        $bustr = 0.25;
        $car = 0.10;
        */
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
                    //$amt = $trn * $distval * $wrkday;
                    if (($distval >= isset($obj['exceptons']['min_km'])) 
                        && ($distval <= isset($obj['exceptons']['max_km'])))   
                    {
                       
                        $amt = $trn * isset($obj['exceptions']['factor']) * $distval * $wrkday * 2;
                    }
                    else
                    {
                        $amt = $trn * $distval * $wrkday * 2;
                    } 
                break;  
                case "CAR": 
                //$amt = computeExp($distval,$car)               
                  //  $amt = $car * $distval * $wrkday;

                    if (($distval >= isset($obj['exceptons']['min_km'])) 
                        && ($distval <= isset($obj['exceptons']['max_km'])))   
                        {
                           
                            $amt = $car * isset($obj['exceptions']['factor']) * $distval * $wrkday * 2;
                        }
                        else
                        {
                            $amt = $car * $distval * $wrkday * 2;
                        }  
                break; 
                case "BIKE":
                //echo $distval;
                
                  if (($distval >= isset($obj['exceptons']['min_km'])) 
                    && ($distval <= isset($obj['exceptons']['max_km'])))   
                        {
                           
                            $amt = $bkamts * isset($obj['exceptions']['factor']) * $distval * $wrkday * 2;
                        }
                    else
                        {
                            $amt = $bkamts * $distval * $wrkday * 2;
                        }   
                        
                /*
                if (($distval >= 5 ) && ($distval <= 10))   
                        {
                           
                            $amt = $bkamts * 2 * $distval * $wrkday;
                        }
                        else
                        {
                            $amt = $bkamts * $distval * $wrkday;
                        }  
                        */                             
                break;
                
                case "BUS":    
                    //$amt = $bustr * $distval * $wrkday;
                    if (($distval >= isset($obj['exceptons']['min_km'])) 
                    && ($distval <= isset($obj['exceptons']['max_km'])))   
                    {
                       
                        $amt = $bustr * isset($obj['exceptions']['factor']) * $distval * $wrkday * 2;
                    }
                    else
                    {
                        $amt = $bustr * $distval * $wrkday * 2;
                    } 
                break;                                                                       
                default:
                    $amt = 0 ;
                break;

                
            }   
                            /*
                function computeExcp($distval, $trtype)
                {
                        if (($distval >= isset($obj['exceptons']['min_km'])) && ($distval <= isset($obj['exceptons']['max_km'])))   
                    {
                       
                        $amt = $bustr * isset($obj['exceptions']['factor']) * $distval * $wrkday;
                    }
                    else
                    {
                        $amt = $bustr * $distval * $wrkday;
                    } 
            
                }

                */

        }                    
       
        return number_format(($amt * 4),2);
    }



?>