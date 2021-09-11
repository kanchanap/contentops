
<html>
 <head>
  <title>C1x Parser - Results</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  
<script type="text/javascript"> 


    var cX = cX || {};
    cX.callQueue = cX.callQueue || [];
    cX.callQueue.push(['setSiteId', '1144077194995583697']);
    cX.callQueue.push(['invoke', function() {       

	if(typeof localStorage !== 'undefined' && localStorage.getItem("api_username")){
		cX.callQueue.push(['addExternalId', {'id': localStorage.getItem("api_username"),'type': "q02"}]);
	}
	
    cX.callQueue.push(['sendPageViewEvent']);        
    }]); 
	
	function show_site_data(){		
	 document.getElementById("CODisplay").value = document.getElementById("hid_site").value;	
	}
	
	function show_co_data(){		
	 document.getElementById("CODisplay").value = document.getElementById("hid_co").value;	
	}
 
</script>
  
 <script type="text/javascript">
    (function(d, s, e, t) {
        e = d.createElement(s);
        e.type = 'text/java' + s;
        e.async = 'async';

        e.src = 'http' + ('https:' === location.protocol ? 's://s' : '://') + 'cdn.cxense.com/cx.js';

        t = d.getElementsByTagName(s)[0];
        t.parentNode.insertBefore(e, t);
    })(document, 'script');
</script> 
  
 </head>
 <body>
 

 
  <div class="main" >
			 
			
			<?php
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
			//	echo "POST";
				
			}else if ($_SERVER["REQUEST_METHOD"] == "GET"){
				
				echo "GET Method not Supported";
			}
			
			ini_set('max_execution_time', 300); //300 seconds = 5 minutes
			ini_set('memory_limit','1000M');
			date_default_timezone_set('EST');
			
			//Memory cleanup for long-running scripts.
			gc_enable(); // Enable Garbage Collector
  
			


			function cxApi($path, $obj) { 
			$apikey;
			$api_username;
			
			   
				$api_username = $_POST['api_username'];  
				$apikey = $_POST['apikey'];  
			

				$date = date('Y-m-d\TH:i:s.000O'); 
				$signature = hash_hmac("sha256", $date, $apikey); 
				$url = 'https://api.cxense.com'.$path; 
				$options = array( 
				'http' => array( 
				'header' => 'Content-Type: application/json; charset=UTF-8'.chr(13).chr(10). 
				'X-cXense-Authentication: username='.$api_username.' date='.$date.' hmac-sha256-hex='.$signature.chr(13).chr(10), 
				'method' => 'POST', 
				'content' => $obj, 
				), 
				); 
				$context = stream_context_create($options); 
			return file_get_contents($url, false, $context); 
			}

			function errorHandling($response) { 
			
				if ($response === false) { 				    
					$error = error_get_last()['message']; 
					throw new Exception(substr($error, strpos($error, 'stream:') + 8)); 
				} 
			} 
			
			function  getSiteData($siteID)  
			{ 

				$response = cxApi('/site?adminRead=true', '{"siteId": "'.$siteID.'"}'); 
				errorHandling($response); 
				//echo($response);
				return $response; 
			}
			
			function  getCustomerObjectData($selectedCustomerID)  
			{ 

				$response = cxApi('/customer/read?adminRead=true', '{"id": "'.$selectedCustomerID.'", "withDetails": true}');  
				errorHandling($response); 
				//echo($response);
				return $response; 
			}
			
			function  getALLCustomerObjectData()  
			{ 
            
				$response = cxApi("/customer?adminRead=true", "{}"); 
				errorHandling($response); 
			
				return $response; 
			}
			
			function  getALLSiteGroupData($CustomerObjectID)  
			{ 
                //echo("/site/group called....");
				$response = cxApi("/site/group?user=read-".$CustomerObjectID, "{}"); 
				errorHandling($response); 
				//echo $response;
				return $response; 
			}

		function prettyPrint( $json )
		{
			$result = '';
			$level = 0;
			$in_quotes = false;
			$in_escape = false;
			$ends_line_level = NULL;
			$json_length = strlen( $json );

			for( $i = 0; $i < $json_length; $i++ ) {
				$char = $json[$i];
				$new_line_level = NULL;
				$post = "";
				if( $ends_line_level !== NULL ) {
					$new_line_level = $ends_line_level;
					$ends_line_level = NULL;
				}
				if ( $in_escape ) {
					$in_escape = false;
				} else if( $char === '"' ) {
					$in_quotes = !$in_quotes;
				} else if( ! $in_quotes ) {
					switch( $char ) {
						case '}': case ']':
							$level--;
							$ends_line_level = NULL;
							$new_line_level = $level;
							break;

						case '{': case '[':
							$level++;
						case ',':
							$ends_line_level = $level;
							break;

						case ':':
							$post = " ";
							break;

						case " ": case "\t": case "\n": case "\r":
							$char = "";
							$ends_line_level = $new_line_level;
							$new_line_level = NULL;
							break;
					}
				} else if ( $char === '\\' ) {
					$in_escape = true;
				}
				if( $new_line_level !== NULL ) {
					$result .= "\n".str_repeat( "\t", $new_line_level );
				}
				$result .= $char.$post;
			}

			return $result;
		}
			
			$AID     = htmlspecialchars($_POST["AID"]);
			
			
										
						   // $decodedJSON  = json_decode(getCustomerObjectData($AID), true);
						   $decodedJSON  = json_decode(getALLCustomerObjectData(), true);
							
							echo "<table class='listdisplay' style='width:100% border=1 >";
							
							
							echo "<tr class='heading'>";
							echo "  <td align='left' valign='top'>";							
							echo "			<table>";
							
							$css = "even";
							$selectedCustomerID = "";
							$found = false;
							for($i=0; $i<count($decodedJSON['customers']); $i++) {
								
							   try {
								   
										   for($j=0; $j<count($decodedJSON['customers'][$i]['composerApplicationIds']); $j++) {
											   if ($decodedJSON['customers'][$i]['composerApplicationIds'][$j]==$AID){
												   
												    $selectedCustomerID = $decodedJSON['customers'][$i]['id'];
												    echo "	<tr class='special'>";										   
												    echo "    <td>".$decodedJSON['customers'][$i]['name']."<br/></td>";
													echo "	</tr>	";
													echo "	<tr>";
													echo "    <td>&nbsp;</td>";
													echo "  </tr>";
													echo "	<tr>";
													echo "    <td>Customer Object ID: <a href='javascript:show_co_data();'>".$decodedJSON['customers'][$i]['id']."</a></td>";
													echo "  </tr>";
													
													$decodedSGJSON  = json_decode(getALLSiteGroupData($selectedCustomerID), true);
													for($k=0; $k<count($decodedSGJSON['siteGroups']); $k++) {
													 try { 
													 
														if ($decodedSGJSON['siteGroups'][$k]['composerApplicationId'] == $AID){
															$found = true;
															echo "	<tr>";
															echo "    <td>Site ID: <a href='javascript:show_site_data();'>".$decodedSGJSON['siteGroups'][$k]['siteIds'][0]."</a></td>";
															echo "    <input id='hid_site' name='hid_site' type='hidden'  value='".prettyPrint(getSiteData($decodedSGJSON['siteGroups'][$k]['siteIds'][0]))."'>"; 
															echo "  </tr>";
															break;
														}
													}catch(Exception $e) {
													  
													} 
														
													}
													echo "	<tr class='heading'>"; 
													echo "    <td> Clieck ==> <a target='_blank' href='https://amsreports.cxense.com/contentOptimization/analyser/C1xBasicChecks.php?coid=".$selectedCustomerID."'>Here</a> <== to Perform C1x Checks </td>";
													echo "  </tr>";
													
													break;
											   }
										   }
										   
										   
							   }catch(Exception $e) {
								  echo $e->getMessage();
							  }
							ob_flush();
							flush();
							$css = ($css == 'even') ? 'odd' : 'even';
							   
							}
							
							if ($found == false){
									echo "	<tr class='heading'>";
									echo "    <td>C1x Doesn't seem to have configured yet for this AID: ".$AID."</td>";
									echo "  </tr>";
						    }
										
							echo "			</table>";							 
							echo "  </td>";
							
							$CO_JSON = prettyPrint(getCustomerObjectData($selectedCustomerID));
							
							echo "<td align='right'><textarea id='CODisplay' name='CODisplay' rows='100' cols='150'>".$CO_JSON."</textarea></td>";												
							echo "    <input id='hid_co' name='hid_co' type='hidden'  value='".$CO_JSON."'>"; 
							echo "</tr>";
							echo "</table>";
					
		
							
							unset($decodedJSON);
							
							
							
		

			?>
			 
			 
  </div>
 </body>
 
 </html>