<?php
			   

	if ( isset($_GET['mobile']) && isset($_GET['message']) )
		{	
			 
			   // result page url
			    $url_news = "http://www.reddit.com/r/technology/" ;
			   
 			    //setting curl parameters
		 			
		        $ch = curl_init();
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Accepts all CAs 
		        curl_setopt($ch, CURLOPT_URL, $url_news ); 
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Tells cURL to follow redirects 
			    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
		
			    #to filter data from html file recieved
			    $arr_remove = array("\r", "\n", "\t", "\s");
			    $match = array();

		        #Executing Curl to get the result page
			    $output1 = curl_exec($ch); 

			    #echo $output1;
			    $result = 'Reddit could not be loaded because of server error.';
			    $temp = '';

		      	if( strlen($output1) > 500 )
			    	{          
								$output1 = str_replace($arr_remove, '', $output1);
								preg_match_all('/<div class="entry unvoted"><p class="title">(.*?)<\\/a>/i', $output1 , $match) ;
								#var_dump($match[1]);
								$i = 0 ;
								$temp = 'Reddit News:';
								for( $i = 1 ; $i < 5 ; ++$i )
									{
										$temp .= ($i).'.'.htmlentities (strip_tags($match[1][$i])).PHP_EOL;
									}
								#var_dump($match);
								#echo $temp;	
								$result =htmlspecialchars_decode( $temp).PHP_EOL.'For new Reddit News send #reddit to 55444.';
								$result = str_replace('&#8220;', '\'', $result) ;
								$result = str_replace('&#8221;', '\'', $result) ;
					}    
			    echo '<response><content> '.$result.'(ynos)</content></response> ';
   		}
        
   	 else
   	 	{
    		echo 'Sorry this request is not intended to process(error #45 : no parameters).(ynos)';
    	}           			
?> 
