
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
	
	
	function openLink(coid,link){
		
      //const match = /masquerade_as_user=([^;]+)/.exec(document.cookie); const user=prompt("Masquerade as user or customer", (match && match[1]) || coid); if(user!=null) document.cookie="masquerade_as_user="+user; location.reload();
	  window.open(link, '_blank').focus();
	
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
			//ini_set('memory_limit','100M');
			date_default_timezone_set('EST');
			
			//Memory cleanup for long-running scripts.
			gc_enable(); // Enable Garbage Collector
			
			$CustomerObjectID     = htmlspecialchars($_POST["CustomerObjectID"]);
			$SHC_Number           = htmlspecialchars($_POST["hid_SHC"]);  
			$ml           		  = htmlspecialchars($_POST["hid_ml"]); 
			$totdocs           	  = htmlspecialchars($_POST["hid_totdocs"]);
			$detevents            = htmlspecialchars($_POST["hid_detevents"]);
			
			


			function cxApi($path, $obj) { 
			$apikey;
			$api_username;
			
			   
				$api_username = $_POST['api_username'];  
				$apikey = $_POST['apikey'];  
			
 
				$date = date('Y-m-d\TH:i:s.000O'); 
				$signature = hash_hmac("sha256", $date, $apikey); 
				$url = 'https://api-gui.cxense.com'.$path; 
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
			
			
			function  getCustomerObjectData($CustomerObjectID)  
			{ 
                // echo("/site/group called....");
				$response = cxApi("/site/group?user=read-".$CustomerObjectID, "{}"); 
				errorHandling($response); 
				//echo($response);
				return $response; 
			}
			
			
			function  checkTraffic($SiteID)  
			{ 
			 
			 
			 $result = ""; 
			 try {
				    $trafficPeriod        = htmlspecialchars($_POST["trafficPeriod"]);
				  
					$response = cxApi('/traffic?adminRead=true', '{"start":"'.$trafficPeriod.'","siteIds":["'.$SiteID.'"],"filters":[{"type":"custom", "group":"userState"}]}' ); 
					errorHandling($response);		 		
					$decodedJSON  = json_decode($response, true);
					$result = $decodedJSON['data']['events'];				
				}catch(Exception $e) {
				  //echo $e->getMessage();
				  $result = "?";
				  //echo $e->getTraceAsString();
				} 		
						
				return $result; 
			}
			
			
			function  checkdetachedTraffic($SiteID)  
			{ 
			 
			 
			 $result = ""; 
			 try {
				    $trafficPeriod        = htmlspecialchars($_POST["trafficPeriod"]);
				  
					$response = cxApi('/traffic?adminRead=true', '{"start":"'.$trafficPeriod.'","siteIds":["'.$SiteID.'"],"filters": [{"type":"not","filter":{"type":"custom","group":"userState"}},{"type":"not","filter":{"type":"custom","group":"cx_channel","item":"amp"}}]}' ); 
					errorHandling($response);		 		
					$decodedJSON  = json_decode($response, true);
					$result = $decodedJSON['data']['events'];				
				}catch(Exception $e) {
				  //echo $e->getMessage();
				  $result = "?";
				  //echo $e->getTraceAsString();
				} 		
						
				return $result; 
			}
			
						
			function  checknormalTraffic($SiteID)  
			{ 
			 
			 
			 $result = ""; 
			 try {
				 
				    $trafficPeriod        = htmlspecialchars($_POST["trafficPeriod"]);
					$response = cxApi('/traffic?adminRead=true', '{"start":"'.$trafficPeriod.'","siteIds":["'.$SiteID.'"],"filters": [{"type":"not","filter":{"type":"custom","group":"cx_channel","item":"amp"}}]}' ); 
					errorHandling($response);		 		
					$decodedJSON  = json_decode($response, true);
					$result = $decodedJSON['data']['events'];				
				}catch(Exception $e) {
				  //echo $e->getMessage();
				  $result = "?";
				  //echo $e->getTraceAsString();
				} 		
						
				return $result; 
			}
			
			
			function  checkDocs($SiteID)  
			{ 
			
			$result = "";
			try {
					$response = cxApi('/document/search?adminRead=true', '{"count":0,"siteId":"'.$SiteID.'"}' );  	 			
					errorHandling($response);				
					$decodedJSON  = json_decode($response, true);
					$result = $decodedJSON['totalCount'];	
				}catch(Exception $e) {
				  //echo $e->getMessage();
				  //echo $e->getTraceAsString();
				}
				return $result; 
			}
			
			function  checkLTx($SiteID,$type,$LTx)  
			{ 
			    $result = "-";
				$response = cxApi('/ml/model/read?adminRead=true', '{"siteId":"'.$SiteID.'"}' ); 				
				errorHandling($response);

				try {
					
					$decodedJSON  = json_decode($response, true);
					for($i=0; $i<count($decodedJSON['models']); $i++) {
						 if ($decodedJSON['models'][$i]['modelType']==$LTx){
							 if($type=="state"){
								$result =  $decodedJSON['models'][$i]['state'];
							 }else if($type=="model"){
								$result =  $response;
							 }
						 }
					}
				
				}catch(Exception $e) {
				  echo $e->getMessage();
			    }
					
				return $result; 
			}
			
			
			function  checkSite($SiteID,$type)  
			{ 
			    $result = "";
				$response = cxApi('/site?adminRead=true', '{"siteId":"'.$SiteID.'"}' ); 				
				errorHandling($response);

				try {
					
					$decodedJSON  = json_decode($response, true); 

					if ($type == "url"){
						
						$result =  $decodedJSON['sites'][0]['url'];
						if(strpos($result, "http") === false){
							$result = "https://".$result;
						}
					
					}					
				
				}catch(Exception $e) {
				  echo $e->getMessage();
			    }
					
				return $result; 
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

			
	
										
						    $decodedJSON  = json_decode(getCustomerObjectData($CustomerObjectID), true);
							
													  
							//echo "<button onclick=\"Check_Structure();\">Check Structure</button>";
							
							echo "<table class='listdisplay' style='width:100% border=1 >";						
							
							echo "<tr class='heading'>";							
							echo "  <td align='center'>Site Group ID</td>";
							echo "	<td align='center'>AID</td>";
							echo "	<td align='center'>Site ID</td>";
							echo "	<td align='center'>URL</td>";
							if($SHC_Number>1){
							echo "	<td align='center'>C1x Traffic</td>";
							    if ($detevents=="T"){ 
									echo "	<td align='center'>Total NON-AMP Traffic</td>";
									echo "	<td align='center'>Detached Traffic</td>";
									echo "	<td align='center'>Detached Ratio</td>";
								}
							
							}
							
							if ($totdocs=="T"){
								echo "	<td align='center'>Total Docs Indexed</td>";
							}
							
							if($SHC_Number>2){
							echo "	<td align='center'>LTs</td>";	
							}
							if($SHC_Number>3){
							echo "	<td align='center'>LTc</td>";								
							}
							if ($ml=="T"){
							echo "	<td align='center'>ML Data</td>";	
							}
							echo "</tr>";
							
					
							$css = "even";
							for($i=0; $i<count($decodedJSON['siteGroups']); $i++) {
								
							   try {
								    
								        if($decodedJSON['siteGroups'][$i]['type']== "permissions_only"){
										   echo "<tr class='special'>";										   
										   echo "<td>".$decodedJSON['siteGroups'][$i]['id']."</td>";
										   echo "<td align='left' colspan='9'><===== This is the C1x top-most site group used for Permission settings</td>";										   
										   echo "</tr>";
										}else if($decodedJSON['siteGroups'][$i]['type']== "single_site"){
											$TrafficHighLight = "";
											$DocHighLight = "";
											$LTsHighLight = "";
											$LTcHighLight = "";
											
											
											
											$url = checkSite($decodedJSON['siteGroups'][$i]['siteIds'][0],"url");  
											
										   echo "<tr class='".$css."'>";										   
										  // echo "<td>".$decodedJSON['siteGroups'][$i]['id']."<a target='_blank' href='https://segments.cxense.com/#list?siteGroupId=".$decodedJSON['siteGroups'][$i]['id']."'>  C1x Segments</a></td>";
										  echo "<td>".$decodedJSON['siteGroups'][$i]['id']."<a target='_blank' onclick='openLink(\"".$CustomerObjectID."\",\"https://segments.cxense.com/#list?siteGroupId=".$decodedJSON['siteGroups'][$i]['id']."\"); return false;'>  C1x Segments</a></td>";
										  

										  echo "<td>".$decodedJSON['siteGroups'][$i]['composerApplicationId']."<a target='_blank' href='https://experience.tinypass.com/xbuilder/experience/load?aid=".$decodedJSON['siteGroups'][$i]['composerApplicationId']."'>  Load Script</a></td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['siteIds'][0]."</td>";
										   echo "<td><a target='_blank' href='".$url."?xpdebug'>".$url."</a></td>";
										   if($SHC_Number>1){											   
											    
												$traffic = checkTraffic($decodedJSON['siteGroups'][$i]['siteIds'][0]);
												if ($traffic < 50){
													$TrafficHighLight = "warn";
												}
												
												echo "<td class='".$TrafficHighLight."'>".$traffic."</td>";	
												
													if ($detevents=="T"){ 
													    $normaltraffic = checknormalTraffic($decodedJSON['siteGroups'][$i]['siteIds'][0]);
														echo "	<td align='center'>".$normaltraffic."</td>";
														$detachedtraffic = checkdetachedTraffic($decodedJSON['siteGroups'][$i]['siteIds'][0]);
														echo "	<td align='center'>".$detachedtraffic."</td>";
														
														$detachedRatio = $detachedtraffic/$normaltraffic;
														if ($detachedRatio > 0.1){
															$DetachedHighLight = "warn";
														}
														echo "	<td class='".$DetachedHighLight."' align='center'>".$detachedRatio."</td>";
													}
												
											
										   }
										   if ($totdocs=="T"){
											 $docs = checkDocs($decodedJSON['siteGroups'][$i]['siteIds'][0]);
												if ($docs < 50){
													$DocHighLight = "warn";
												}  
												echo "<td class='".$DocHighLight."'>".$docs."</td>";
										   }
										   
										   
										   if($SHC_Number>2){
											    
												$LTs = checkLTx($decodedJSON['siteGroups'][$i]['siteIds'][0],"state","LTs");
												if ($LTs == "failed" OR $LTs == "created" OR $LTs == "-"){
													$LTsHighLight = "warn";
												}
												echo "<td class='".$LTsHighLight."'>".$LTs."</td>";	
										   }
										   if($SHC_Number>3){
											    
												$LTc = checkLTx($decodedJSON['siteGroups'][$i]['siteIds'][0],"state","LTc");
												if ($LTc == "failed" OR $LTc == "-"){
													$LTcHighLight = "warn";
												}
												echo "<td class='".$LTcHighLight."'>".$LTc."</td>";												
										   }
										   if ($ml=="T"){
											    echo "<td align='right'><textarea id='LTxDisplay' name='LTxDisplay' rows='15' cols='40'>".prettyPrint(checkLTx($decodedJSON['siteGroups'][$i]['siteIds'][0],"model","LTc"))."</textarea></td>";												
					 
										   }
										   
										   echo "</tr>";
										}
										   

								   
							   }catch(Exception $e) {
								  echo $e->getMessage();
								  //echo $e->getTraceAsString();
							  }
							   
							   
							ob_flush();
							flush();
							$css = ($css == 'even') ? 'odd' : 'even';
							   
							}		
							
							unset($decodedJSON);
							
							echo "</table>";
							
		

			?>
			 
			 
  </div>
 </body>
 
 </html>