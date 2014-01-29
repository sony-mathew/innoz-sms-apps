<?php
			   
ignore_user_abort(TRUE);

	if ( isset( $_GET[ 'mobile' ] ) && isset( $_GET[ 'message' ] ) )
		{	
			    $time_flag = 0 ;
          if( substr_count(strtolower($_GET['message']), 'time' ))  { $time_flag = 1 ;}
      
          if( date('d:m:y') == file_get_contents('date.txt') )
              {   
                $result = file_get_contents(($time_flag?'movies_time.txt':'movies.txt'));    
              }


       else       
         { 
         // result page url
			   $url = "http://www.oberonmall.com/home/cinemax" ;
				//setting curl parameters
 			
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Accepts all CAs 
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Tells cURL to follow redirects 
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
#to filter data from html file recieved
               	$arr_remove = array("\r", "\n", "\t", "\s");
               	$match = array();

#Executing Curl to get the result page
                $output1 = curl_exec($ch); 

//                echo $output1;
                $result = 'We believe the data gathering site is down. So the request movie timings cannot be dislayed right now. 
                           Please try after sometime.';


      if( strlen($output1) > 2000 )
            {          
        			  $result = '';
                $output1 = str_replace($arr_remove, '', $output1);
                preg_match_all('/<tr>(.*?)<!--/i', $output1 , $match) ;
                
                $timings = array() ;
                $movies = array() ;
                for( $i = 1 ; isset( $match[1][$i] ) ; ++$i )
                  {     $temp1 = explode('</td>', $match[1][$i]) ;
                        $timings[$i] = strip_tags( $temp1[0] ) ; 
                        $movies[$i] = strip_tags( $temp1[2] ) ;  

               //     $result = $result.''.$i.'.'. $match[1][$i]  ; }
                   }

                 $movies_unique = array_unique($movies) ;

               // var_dump($movies_unique);

                $timings_unique = array();
               
                foreach( $movies as $base => $content)
                        {        
                            foreach ($movies_unique as $key => $value) 
                                { 
                                  if( $value == $content )
                                      {
                                          $timings_unique[$key] = (isset($timings_unique[$key])?$timings_unique[$key]:'').$timings[$base].',';
                                      }
                                }
                        }          

                $temp1 = '';
                $temp2 = '';  
                $count = 0 ;
                $result1 = '';
                $result2 = '';
                foreach ($movies_unique as $key => $value) 
                    {  ++$count ;
                       $result1 .= $temp1 ;
                       $temp1 = $count.'.'.$value.'('.$timings_unique[$key].')'.'
';                      
                       $result2 .= $temp2 ;
                       $temp2 = $count.'.'.$value.'
'; 
                    }

                file_put_contents('movies.txt', $result2);
                file_put_contents('movies_time.txt', $result1);
                file_put_contents('date.txt', date('d:m:y') );
                $result = ($time_flag?$result1 : $result2) ;    
            }
      }          
    echo '
          <response>
                <content> '.$result.'(ynos)
                </content>
          </response> ';
    exit;      
        }
        
    else
    	{
    		echo 'Sorry this request is not intended to process(error #45 : no parameters).(ynos)';
    	}  
   exit;            			
?> 

