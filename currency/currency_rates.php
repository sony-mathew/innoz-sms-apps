<?php

if ( isset( $_GET[ 'mobile' ] ) && isset( $_GET[ 'message' ] ) )
    { 
              $data = '';
              $fp = fsockopen("www.x-rates.com", 80, $errno, $errstr, 30);
              if (!$fp) 
                    {   
                      echo "$errstr ($errno)<br />\n"; 
                      exit;
                    } 
              else  {
                        $out = "GET /table/?from=INR&amount=1.00 HTTP/1.1\r\n";
                        $out .= "Host: www.x-rates.com\r\n";
                        $out .= "Connection: Close\r\n\r\n";
                        fwrite($fp, $out);
                        $i = 0 ;
                        while (!feof($fp)) 
                            {
                              $i ++ ;
                              if( $i < 184)   { $data .= fgets($fp, 128); }
                              else            { break;         } 
                            }
                        fclose($fp);
                    }

              $match = array();
              $arr_remove = array("\r", "\n", "\t", "\s");
              $data = str_replace($arr_remove, '', $data);
              preg_match_all('/<tr>(.*?)<\\/tr>/i', $data , $match) ;
              $output = '' ;
              for ($i=1; $i < 11; $i++) 
                  { 
                      if( isset( $match[0][$i] ) ) 
                            {
                              $temp = explode('</td>', $match[0][$i]);
                              //var_dump($temp);
                              $output .= strip_tags( $i.'.'.$temp[0].'->'.$temp[2]).PHP_EOL ;
                            } 
                  }

              $output = 'Base Currency: Indian Rupee (INR)'.PHP_EOL.$output.'(ynos)';
              echo '<response><content> '.$output.'</content></response> '; 
    } 

else
    {
        echo 'Sorry this request is not intended to process(error #45 : no parameters).(ynos)';
    }   

?>
