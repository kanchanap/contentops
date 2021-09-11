
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


			
			$CustomerObjectID     = htmlspecialchars($_POST["CustomerObjectID"]);
			
			
										
						    $decodedJSON  = json_decode(getCustomerObjectData($CustomerObjectID), true);
							
							echo "<table class='listdisplay' style='width:100% border=1 >";
							
							
							echo "<tr class='heading'>";
							echo "  <td align='left'>Customer Object ID</td>";
							echo "  <td align='left'>Site Group ID</td>";
							echo "	<td align='left'>AID</td>";
							echo "	<td align='left'>Site ID</td>";
							echo "</tr>";
							
					
							$css = "even";
							for($i=0; $i<count($decodedJSON['siteGroups']); $i++) {
								
							   try {
								   
								        if($decodedJSON['siteGroups'][$i]['type']== "permissions_only"){
										   echo "<tr class='special'>";										   
										   echo "<td>".$CustomerObjectID." <a href='https://detox.cxense.com/c1xmigration/".$CustomerObjectID."'> ==> Click Here to See Detox data <== </a></td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['id']."</td>";
										   echo "<td align='center' colspan='2'>This is the C1x top-most site group used for Permission settings</td>";										   
										   echo "</tr>";
										}else if($decodedJSON['siteGroups'][$i]['type']== "single_site"){
										   echo "<tr class='".$css."'>";										   
										   echo "<td>".$CustomerObjectID."</td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['id']."</td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['composerApplicationId']."</td>";
										   echo "<td>".$decodedJSON['siteGroups'][$i]['siteIds'][0]."</td>";
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