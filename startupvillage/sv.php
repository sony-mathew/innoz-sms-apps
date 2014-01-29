<?php
			   

	if ( isset($_GET['mobile']) && isset($_GET['message']) )
		{	
			 
			   // result page url
			    $url_news = "http://www.startupvillage.in/news/" ;
			    $url_blog = "http://www.startupvillage.in/svblog/" ;
			   
			    $flagg = 0 ;
 			    if( substr_count($_GET['message'],'news') )		{	 $flagg = 1 ; }
 			
 			    //setting curl parameters
		 			
		        $ch = curl_init();
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Accepts all CAs 
		        curl_setopt($ch, CURLOPT_URL, ($flagg?$url_news:$url_blog) ); 
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Tells cURL to follow redirects 
			    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
		
			    #to filter data from html file recieved
			    $arr_remove = array("\r", "\n", "\t", "\s");
			    $match = array();

		        #Executing Curl to get the result page
			    $output1 = curl_exec($ch); 

			    #echo $output1;
			    $result = '';
			    $temp = '';

		      	if( strlen($output1) > 2000 )
			    	{          
						$output1 = str_replace($arr_remove, '', $output1);
						if( $flagg == 1 )
							{	
								preg_match_all('/<li><a(.*?)<\\/a>/i', $output1 , $match) ;
								$i = 0 ;
								$temp = 'SV NEWS:';
								//var_dump($match);
								for( $i = 0 ; $i < 6 ; ++$i )
									{
										$temp .= ($i+1).'.'.htmlentities (strip_tags('<div '.$match[1][$i]) ).PHP_EOL;
									}
								#var_dump($match);
								#echo $temp;	
								$result =htmlspecialchars_decode( $temp).PHP_EOL.'For SV News send #startupvillage news to 55444.';
								$result = str_replace('&#8216;', '\'', $result) ;
								$result = str_replace('&#8217;', '\'', $result) ;
							#var_dump($match);
							}
						else
							{							
								preg_match_all('/<h1 class=(.*?)<\\/a><\\/h1>/i', $output1 , $match) ;
								$i = 0 ;
								$temp = 'SV BLOG POSTS:';
								for( $i = 0 ; $i < 6 ; ++$i )
									{
										$temp .= ($i+1).'.'.htmlentities (strip_tags('<div '.$match[1][$i]) ).PHP_EOL;
									}
								#var_dump($match);
								#echo $temp;	
								$result =htmlspecialchars_decode( $temp).PHP_EOL.'For SV News send #startupvillage news to 55444.';
								$result = str_replace('&#8220;', '\'', $result) ;
								$result = str_replace('&#8221;', '\'', $result) ;
							}
            		}    
			    echo '<response><content> '.$result.'(ynos)</content></response> ';
   		}
        
   	 else
   	 	{
    		echo 'Sorry this request is not intended to process(error #45 : no parameters).(ynos)';
    	}           			
?> 
