
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
	
	
	function Check_Structure(){
		
	//	alert(document.getElementById("hid_structure").value);
		
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
			
			
			function  getCustomerObjectData($CustomerObjectID)  
			{ 

				$response = cxApi("/site/group?user=read-".$CustomerObjectID, "{}"); 
				errorHandling($response); 
				//echo($response);
				return $response; 
			}
			
			
			function  checkTraffic($SiteID)  
			{ 
			
				$response = cxApi('/traffic?admin=true', '{"start":"-1d","siteIds":["'.$SiteID.'"]}' ); 
				errorHandling($response);				
				$decodedJSON  = json_decode($response, true);
				$result = $decodedJSON['data']['events'];				
				 				
				return $result; 
			}
			
			
			function  checkDocs($SiteID)  
			{ 
			
				$response = cxApi('/document/search?admin=true', '{"count":0,"siteId":"'.$SiteID.'"}' ); 				
				errorHandling($response);				
				$decodedJSON  = json_decode($response, true);
				$result = $decodedJSON['totalCount'];	
				return $result; 
			}
			
			function  checkLTx($SiteID,$type,$LTx)  
			{ 
			    $result = "-";
				$response = cxApi('/ml/model/read?admin=true', '{"siteId":"'.$SiteID.'"}' ); 				
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
				$response = cxApi('/site?admin=true', '{"siteId":"'.$SiteID.'"}' ); 				
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

			
			$CustomerObjectID     = htmlspecialchars($_POST["CustomerObjectID"]);
			$SHC_Number           = htmlspecialchars($_POST["hid_SHC"]);   
			
										
						    $decodedJSON  = json_decode(getCustomerObjectData($CustomerObjectID), true);
							
													  
							//echo "<button onclick=\"Check_Structure();\">Check Structure</button>";
							
							echo "<table class='listdisplay' style='width:100% border=1 >";						
							
							echo "<tr class='heading'>";							
							echo "  <td align='left'>Site Group ID</td>";
							echo "	<td align='left'>AID</td>";
							echo "	<td align='left'>Site ID</td>";
							if($SHC_Number>1){
							echo "	<td align='left'>Traffic (Last 1 day)</td>";
							echo "	<td align='left'>Total Docs Indexed</td>";							
							}
							if($SHC_Number>2){
							echo "	<td align='left'>LTs</td>";	
							}
							if($SHC_Number>3){
							echo "	<td align='left'>LTc</td>";	
							echo "	<td align='center' style='width: 50px'>Model</td>";
							}
							echo "</tr>";
							
					
							$css = "even";
							for($i=0; $i<count($decodedJSON['siteGroups']); $i++) {
								
							   try {
								    
								        if($decodedJSON['siteGroups'][$i]['type']== "permissions_only"){
										   echo "<tr class='special'>";										   
										   echo "<td>".$decodedJSON['siteGroups'][$i]['id']."</td>";
										   echo "<td align='center' colspan='7'>This is the C1x top-most site group used for Permission settings</td>";										   
										   echo "</tr>";
										}else if($decodedJSON['siteGroups'][$i]['type']== "single_site"){
											$TrafficHighLight = "";
											$DocHighLight = "";
											$LTsHighLight = "";
											$LTcHighLight = "";
											
											$traffic = checkTraffic($decodedJSON['siteGroups'][$i]['siteIds'][0]);
											if ($traffic < 100){
												$TrafficHighLight = "warn";
											}
											$docs = checkDocs($decodedJSON['siteGroups'][$i]['siteIds'][0]);
											if ($docs < 50){
												$DocHighLight = "warn";
											}
											
											$LTs = checkLTx($decodedJSON['siteGroups'][$i]['siteIds'][0],"state","LTs");
											if ($LTs == "failed" OR $LTs == "created" OR $LTs == "-"){
												$LTsHighLight = "warn";
											}
											
											$LTc = checkLTx($decodedJSON['siteGroups'][$i]['siteIds'][0],"state","LTc");
											if ($LTc == "failed" OR $LTc == "-"){
												$LTcHighLight = "warn";
											}
											
											$url = checkSite($decodedJSON['siteGroups'][$i]['siteIds'][0],"url");  
											
										   echo "<tr class='".$css."'>";										   
										   echo "<td>".$decodedJSON['siteGroups'][$i]['id']."<a target='_blank' href='https://segments.cxense.com/#list?siteGroupId=".$decodedJSON['siteGroups'][$i]['id']."'>  Segments</a></td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['composerApplicationId']."<a target='_blank' href='https://experience.tinypass.com/xbuilder/experience/load?aid=".$decodedJSON['siteGroups'][$i]['composerApplicationId']."'>  Load Script</a></td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['siteIds'][0]."  <a target='_blank' href='".$url."?xpdebug'>".$url."</a></td>";
										   
										   if($SHC_Number>1){
										    echo "<td class='".$TrafficHighLight."'>".$traffic."</td>";	
											echo "<td class='".$DocHighLight."'>".$docs."</td>";
										   }
										   if($SHC_Number>2){
										    echo "<td class='".$LTsHighLight."'>".$LTs."</td>";	
										   }
										   if($SHC_Number>3){
										    echo "<td class='".$LTcHighLight."'>".$LTc."</td>";												
										    echo "<td style='width: 50px'><textarea id='LTxDisplay' name='LTxDisplay' rows='15' cols='50'>".prettyPrint(checkLTx($decodedJSON['siteGroups'][$i]['siteIds'][0],"model","LTc"))."</textarea></td>";												
										   }
										   
										   echo "</tr>";
										}
										   

								   
							   }catch(Exception $e) {
								  echo $e->getMessage();
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