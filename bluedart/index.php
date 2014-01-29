<?php
			   

	if ( isset( $_GET[ 'mobile' ] ) && isset( $_GET[ 'message' ] ) )
		{	
			   $numbers = trim( $_GET['message'] );

			   // tracking url
			   $url = "http://www.bluedart.com/servlet/RoutingServlet" ;
			   
			   //specify whether the given number is waybill number or reference number
			   $type = array( 'awb', 'ref') ; 
			   
			   //all the post data
               $fields = array( 'handler' => 'tnt', 'action' => 'awbquery' , 'awb' => $type[0], 'numbers' => $numbers, ); 
               
               $fields_string = ''; 
               foreach($fields as $key=>$value) 
                     {         $fields_string .= $key . '=' . $value . '&';    } 
               rtrim($fields_string, '&'); 
               $arr_remove = array("\r", "\n", "\t", "\s");
 				
 				//setting curl parameters
 			
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Accepts all CAs 
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Tells cURL to follow redirects 
                curl_setopt($ch, CURLOPT_POST, count($fields)); 
        
#flag to indicate wheteher shipment details found or not        
				$flag = 0 ; 

#to filter data from html file recieved
               	$arr_remove = array("\r", "\n", "\t", "\s");
               	$match = array();

#Check the Waybill Number
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string); 
                $output1 = curl_exec($ch); 

#If waybill number not found then check reference number also
                if ( strpos( $output1 , "No matching Waybill" ) )
                		{
							//all the post data
               				$fields2 = array( 'handler' => 'tnt', 'action' => 'awbquery' , 'awb' => $type[1], 'numbers' => $numbers, ); 
               				$fields_string = '' ;
               				foreach($fields2 as $key=>$value) 
                     				{         $fields_string .= $key . '=' . $value . '&';    } 
               				rtrim($fields_string, '&'); 
                			
               				//execute curl	
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                			$output1 = curl_exec($ch);

                			if( strpos( $output1 , "No matching Waybill" ) )	{   $flag = 0 ;	}
                			else 												{	$flag = 2 ;	}		
                		}
                else 	{	$flag = 1;	}

        if( $flag > 0 )
        		{
        			$which = (($flag == 1) ? 'Waybill No.' : 'Refernece No.' );
        			$output1 = str_replace($arr_remove, '', $output1);
                	preg_match('/Pickup Date(.*?)Your Email ID/i', $output1 , $match) ;
                	$result = $match[1];
                	$result = strip_tags($result);
                	$result = str_replace('From', ','.PHP_EOL.'
											From:', str_replace('Status', ', '.PHP_EOL.'
											Status:', str_replace('Expected Date of Delivery', ', '.PHP_EOL.'
											Expected Date of Delivery:', $result)));
                	$result = $which.':'.$numbers.PHP_EOL.'PickupDate:'.$result.PHP_EOL.'(ynos)';
        		}      
        else
        		{
        			$result = 'No Shipment details found. Check the tracking number you provided. 
        			(ynos)';
        		}		  	
    echo '
          <response>
                <content> '.$result.'
                </content>
          </response> ';
        }
        
    else
    	{
    		echo 'Sorry this request is not intended to process(error #45 : no parameters).';
    	}           			
?> 

