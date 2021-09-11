<?php
$pass = false;

# verifies the existence of cookies we need and refreshes the timer on them
# redirects to login for failure

$required = array('username', 'password', 'offset');

if(isset($_COOKIE['offset'])) {
  $offset = $_COOKIE['offset'];
}

foreach($required as $field) {
  if(!isset($_COOKIE[$field]) || !$offset) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $LOGIN . '?forward=' . $_SERVER['REQUEST_URI'] . '&error=Your Session has Timed Out');
  }

  # refresh this cookie
  setcookie($field, $_COOKIE[$field], time() + $offset);
}


if( $_COOKIE["username"] == $REGISTERED_USER && $_COOKIE["password"] == $REGISTERED_PASS) {		  
	$pass = true;
 }else{
	$pass = false;        
 }
 
 if($pass){	 
	 
 }else{
	header('Location: http://' . $_SERVER['HTTP_HOST'] . $LOGIN . '?forward=' . $_SERVER['REQUEST_URI'] . '&error=Your Session has Timed Out'); 
 }


?>
