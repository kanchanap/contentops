<?php
require_once('config.rc');
require_once('auth.php');
?>

<html>
 <head>
  <title>C1x Basic checks</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  

<script type="text/javascript">


function loadFromLS(name) {
	
	if(localStorage.getItem("api_username")){
	  document.form1.api_username.value = localStorage.getItem("api_username");
	}
	if(localStorage.getItem("apikey")){
	  document.form1.apikey.value = localStorage.getItem("apikey");
	  document.getElementById("remember").checked = true;
	  
	}
	
}

function checkClick(){

	 if(document.getElementById("remember").checked == true){
	 localStorage.setItem('apikey', document.form1.apikey.value);
	 }else{
	 localStorage.removeItem("apikey");	 
	 } 

}	

function checkML(){

	 if(document.getElementById("ml").checked == true){
	 document.getElementById("hid_ml").value = "T";
	 }else{
	 document.getElementById("hid_ml").value = "F";	 
	 } 
    
}

function checktotdocs(){

	 if(document.getElementById("totdocs").checked == true){
	 document.getElementById("hid_totdocs").value = "T";
	 }else{
	 document.getElementById("hid_totdocs").value = "F";	 
	 } 
    
}	

function checkdetevents(){

	 if(document.getElementById("detevents").checked == true){
	 document.getElementById("hid_detevents").value = "T";
	 }else{
	 document.getElementById("hid_detevents").value = "F";	 
	 } 
    
}	

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
 <body onLoad=loadFromLS();>  
 
	<?php
	$CustomerObjectID = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//	echo "POST";
		
	}else if ($_SERVER["REQUEST_METHOD"] == "GET"){
		
		$CustomerObjectID     = htmlspecialchars($_GET["coid"]);
		
	}
	
	?>
 
<form name='form1' action="C1xBasicChecksParser.php" method="post" target="Show_Log">  

<table border=0>
 <tr> 
		<td align='left' colspan='2'>Cxense User Name</td> 
		<td align='left' colspan='2'><input id="api_username" name="api_username" type="text" size="55" value="Enter Cxense API username" onClick="this.value=''">  </td>  
 </tr>
  <tr> 
		<td align='left' colspan='2'>Cxense API Key</td> 
		<td align='left' colspan='2'><input id="apikey" name="apikey" type="password" size="55" value="Enter Cxense apikey" onClick="this.value=''" > <input type="checkbox" id="remember" onclick="checkClick()"> Remember Read Only API Key on this Browser Local Storage  </td>  
 </tr>
 <tr> 
		<td align='left' colspan='2'>Customer Object ID</td> 
		<td align='left' colspan='2'><input id="CustomerObjectID" name="CustomerObjectID" type="text" size="55" value="<?=$CustomerObjectID?>" onClick="this.value=''">  </td>  
 </tr>
 
 <tr> 
  <td align='left' colspan='2'><b>Select Health Check Number</b></td>
		<td align='left'  colspan='2'>
		<input id="hid_SHC" name="hid_SHC" type="hidden"  value=""> 
	    	<select name="SHC" id="SHC">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">3++</option>
			</select>
			<input type="checkbox" id="ml" name="ml" onclick="checkML()"> ML Data
			<input id="hid_ml" name="hid_ml" type="hidden"  value="F"> 
			
			<input type="checkbox" id="totdocs" name="totdocs" onclick="checktotdocs()"> Total Indexed Documents
			<input id="hid_totdocs" name="hid_totdocs" type="hidden"  value="F"> 
			
			<input type="checkbox" id="detevents" name="detevents" onclick="checkdetevents()"> Detached events
			<input id="hid_detevents" name="hid_detevents" type="hidden"  value="F">
		</td> 

</tr>
 <tr> 
		<td align='left' colspan='2'>Traffic Comparison Period</td> 
		<td align='left' colspan='2'><input id="trafficPeriod" name="trafficPeriod" type="text" size="3" value="-24h" onClick="this.value=''">  </td>  
 </tr>


 <tr>
		 <td align='left' colspan='2'>Search</td>		  
		 <td align='left'><input type='button' value='search' onClick= 'show_val()';>  </td> 		 
		 
		  
  </tr>


  
</table>
 
 </br></br></br>

 <script language='javascript'>
 

 
 function show_val(){
	 
 document.form1.hid_SHC.value = document.getElementById("SHC").value; ;
	 
 if(document.form1.CustomerObjectID.value==''){
	 
	 alert('You must Enter a Customer Object ID');
	 document.form1.CustomerObjectID.focus(); 
	 return false;
 }
 
  if(document.form1.trafficPeriod.value==''){
	 
	 alert('You must Enter a traffic Period.  Ex: -2h, -1d etc');
	 document.form1.trafficPeriod.focus(); 
	 return false;
 }
 
  if(document.form1.api_username.value=='Enter Cxense API username'){	 
	 alert('You must Enter your api username');
	 document.form1.api_username.focus(); 
	 return false;
 }
 
   if(document.form1.apikey.value=='Enter Cxense apikey'){	 
	 alert('You must Enter your api key');
	 document.form1.apikey.focus(); 
	 return false;
 }

 
if (typeof(Storage) !== "undefined") {

	 localStorage.setItem('api_username', document.form1.api_username.value); 
	 
	 if(document.getElementById("remember").checked == true){
	 localStorage.setItem('apikey', document.form1.apikey.value);
	 }else{
	 localStorage.removeItem("apikey");	 
	 }
 
}




  document.form1.submit();
 }
 
 </script>
 
 <?php
 
 echo ("<iframe name='Show_Log' id='Show_Log' width='100%' height='90%'></iframe> ");
	
 ?>
	
</form>
	
</body>

</html>