<?php
require_once('config.rc');
require_once('auth.php');
?>

<html>
 <head>
  <title>AID Checker</title>
  <link rel="stylesheet" type="text/css" href="main.css">
  
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>

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
 
<form name='form1' action="AIDCheckerParser.php" method="post" target="Show_Log">  

<table border=0>
 <tr> 
		<td align='left' colspan='2'>Cxense User Name</td> 
		<td align='left' colspan='2'><input id="api_username" name="api_username" type="text" size="55" value="Enter Cxense API username" onClick="this.value=''">  </td>  
 </tr>
  <tr> 
		<td align='left' colspan='2'>Cxense API Key</td> 
		<td align='left' colspan='2'><input id="apikey" name="apikey" type="password" size="55" value="Enter Cxense apikey" onClick="this.value=''" > <input type="checkbox" id="remember" onclick="checkClick()"> Remember ReadOnly API Key on this Browser Local Storage  </td>  
 </tr>
 <tr> 
		<td align='left' colspan='2'>Composer AID</td> 
		<td align='left' colspan='2'><input id="AID" name="AID" type="text" size="55" value="3UHressLnd" onClick="this.value=''">  </td>  
 </tr>

 <tr>
		 <td align='left' colspan='2'>Search</td>		  
		 <td align='left'><input type='button' value='search' onClick= 'show_val()';>  </td> 		 
		 
		  
  </tr>


  
</table>
 
 </br></br></br>

 <script language='javascript'>
 

 
 function show_val(){
	 
 if(document.form1.AID.value==''){
	 
	 alert('You must Enter a Customer Object ID');
	 document.form1.AID.focus(); 
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