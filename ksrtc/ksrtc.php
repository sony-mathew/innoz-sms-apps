<?php


	if ( isset( $_GET[ 'mobile' ] ) && isset( $_GET[ 'message' ] ) )
		{	

			$stations   = 	array('chief office'	,'alappuzha',	'aluva',	'attingal',	'changanassery',	'chengannur',	'cherthala',	'ernakulam',
					'kannur',	'kasergod',	'kayamkulam',	'kollam',	'kottarakkara',	'kottayam',	'kozhikode',	'muvattupuzha',	'nedumangad',
						'neyyatinkara',	'pala',	'palakkad',	'pappanamcode',	'pathanamthitta',	'perumbavoor',	'sulthan bathery',	'thiruvalla',
						'thrissur',	'trivandrum', 'thiruvanthapuram',	'vizhinjam',	'adoor',	'ankamali',	'aryanad',	'chadayamangalam',	
						'chalakudy',	'chathannur',	'chittoor',	'erattupettah',	'guruvayoor',	'harippad',	'kalpetta',	'kanhangad',	
						'kaniyapuram',	'karunagappally',	'kattakkada',	'kattappana',	'kilimanoor',	'kodungalloor',	'kothamangalam',	
						'kumaly',	'mala',	'malappuram', 'mananthavady',	'mavelikkara',	'north paravoor',	'parassala',	'pathanapuram',	
						'payyannur',	'perinthalmanna',	'peroorkkada',	'piravom',	'ponkunnam',	'ponnani',	'poovar',	'punalur',	
						'thalassery',	'thamarassery',	'thodupuzha',	'thottipalam',	'vaikom',	'vellanad',	'vellarada',	'venjaramoodu');
			$phone      = 	array( '0471 2471011', '0477 	2251518' , '0484 	2624007','0470 	2622394','0481 	2421824','0479 	2452213', '0478 	2813052', '0484 	2360531','0497 	2705960','0499 	4225677','0479 	2445249','0474 	2751053','0474 	2452812','0481 	2562935','0495 	2390350','0485 	2832626','0472 	2802396','0471 	2222225','0482 	2212711','0491 	2527298','0471 	2491609','0468 	2229213','0484 	2523411','0493 	6224217','0469 	2601345','0487 	2421842','0471 	2323979','0471 	2461013','0471 	2480365','0473 	4224767',' 	0484 	2622920','0472 	2853900','0474 	2476200','0480 	2701638','0474 	2592900','0492 	3227488',' 	0482 	2272230','0487 	2556210','0479 	2412820','0493 	6203040','0467 	22107055','0471 	2752533','0476 	2620466','0471 	2290381','0486 	8252333','0470 	2672617','0480 	2803155','0485 	2862202','0486 	9224242','0480 	2890438',' 	0483 	2736240','0493 	5240240','0479 	2302282','0484 	2444439','0471 	2202058','0475 	2353769','0498 	5203699','0493 	3227422','0471 	2437572','0485 	2265533','0482 	8221333','0494 	2666396','0471 	2210047','0475 	2222636','0490 	2343333','0495 	2224217','0486 	2222388',' 	0496 	2565944','0482 	9231210','0472 	2882986','0471 	2242029','0472 	2874242');
			$shortcodes = 	array('CO','ALP','ALY','ATL','CHR' ,'CGR','CTL','EKM','KNR','KGD','KYM','KLM','KTR','KTM','KKD','MVP','NDD','NTA','PLA','PLK','PPD','PTA','PBR','SBY','TVL','TSR','TVM','CTY','VZM','ADR','ANK','ARD','CDM','CLD','CHT','CTR','ETP','GVR','HPD','KPT','KHD','KPM','KNP','KTD','KTP','KMR','KDR','KMG','KMY','MLA','MLP','MND','MVK','NPR','PSL','PPM','PNR','PMN','PRK','PVM','PNK','PNI','PVR','PLR','TLY','TSY','TDP','TPM','VKM','VND','VRD','VJD') ;


			$msg = strtolower( trim( $_GET['message'] ) ) ;			
			if( strlen( $msg ) < 1 )
				{
					echo '<response><content> Send "#kstrc <station name>" to get the phone number of that depot or sub-depot.'.PHP_EOL.' Eg. : "#ksrtc trivandrum"'.PHP_EOL.
						 'Chief Office KSRTC phone : '.$phone[0].PHP_EOL.'(ynos)</content></response>';
					exit;	  	
				}

			$count = 0 ;
			$temp = '' ;

			foreach ($stations as $key => $value) 
					{
						if( substr_count( $value , $msg) || substr_count($shortcodes[$key], $msg) )
							{
								++$count;
								if( $count < 6 )
									{
									   $temp .=	$count.'.'.'Station :'.str_replace( $msg, strtoupper($msg), $value ).', PH :'.$phone[$key].', Station Code:'.$shortcodes[$key].PHP_EOL ;
									}
							}
					}

			$temp = 'Your query : "'.$_GET['message'].'"'.PHP_EOL.$count.' results found.'.PHP_EOL.$temp.PHP_EOL.'(ynos)';
			echo '<response><content> '.$temp.'</content></response> ';	
		}	

	  else
    	{
    		echo 'Sorry this request is not intended to process(error #45 : no parameters).(ynos)';
    	} 	

?>