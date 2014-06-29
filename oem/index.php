<?php
 
//include_once "facebook.php";

//production
//$facebook = new Facebook(array('appId'=>'373800562643193','secret'=>'b1196821be94e65d34d9d532a25c696d','cookie'=>true));

//development  
//$facebook = new Facebook(array('appId'=>'265851746845272','secret'=>'8e26a9a1cc53e4f19631e7796011da91','cookie'=>true));

//$session = $facebook->getUser();

$server = $_GET['id'];
$user = $_SERVER['REMOTE_ADDR'];
$oi = $_GET['oi'];
$op = $_GET['op'];
$userip = $_GET['u'];

if ($userip) {
	$oi = $server;
	$op = $oi;
}

if(!$server){
    echo "<p>You do not have permissions to access this server</p>";
}
else{
    $random = rand(0,$number_of_friends-1);
	$lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
	$curlang = "";
	$country = "";
	
	if (strlen($lang) >= 2) {
		$curlang = substr($lang, 0, 2);
	}
	else {
		$lang = $user_profile['locale'];
		$curlang = substr($lang, 0, 2);
	}

	if (strlen($lang) >= 5) {
		$country = substr($lang, 3, 2);
	}
	
	if (!$curlang)
		$curlang = 'en';
}
 
$rand = rand(1000000, 10000000);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:og="http://ogp.me/ns#"
<head>
	<title>Babelizer</title>
	
	<link rel="stylesheet" href="css/reset.css" />
	<link href="themes/base/jquery.ui.selectmenu.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="css/excite-bike/jquery-ui-1.8.20.custom.css" />
	<link href="themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="css/style.css?r=<?= $rand ?>" />
	<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
	
</head>
<body>
	<div id="language">Select language: <select id="lang-select" name="language"><option>English</option><option>Polish</option></select></div>
	<div id="main-chat">
		<div class="main-chat-header" id=chatTopBar></div>
		<div class="main-chat-content" id="chatLineHolder">
			
			<div class="clear"></div>
		</div>
		<div id="main-chat-form">
   			<div class="tip"></div>
		
			<!--input type="text" class="main-chat-input"/><input type="submit" class="submit-button" /-->

	       	<form id="loginForm" method="post" action="">
	           	<input type="hidden" id="name" name="name" class="rounded" maxlength="16" value="user<?=$rand?>"/>
	           	<input type="hidden" id="email" name="email" class="rounded" value="<?=$user ?>"/>
	           	<input type="hidden" id="server" name="server" class="rounded" value="<?=$server ?>"/>
	           	<input type="hidden" id="oi" name="oi" class="rounded" value="<?=$oi ?>"/>
	           	<input type="hidden" id="op" name="op" class="rounded" value="<?=$op ?>"/>
	           	<input type="hidden" id="userip" name="userip" class="rounded" value="<?=$userip ?>"/>
	       	</form>

	       	<form id="submitForm" method="post" action="">
				<input type="hidden" id="chatRoom" name="chatRoom" value="1"/>
				<input type="hidden" id="curLang" name="curLang" value="<?=$curlang ?>"/>
				<input type="hidden" id="lang" name="lang" value="<?=$curlang ?>"/>
				<input type="hidden" id="country" name="country" value="<?=$country ?>"/>
	            <input type="text" id="chatText" name="chatText" class="main-chat-input" maxlength="255" />
				<!--textarea id="chatText" name="chatText" class="textarea-message">Message</textarea-->
				<input type="submit" class="submit-button" id="SubmitButton" value="Chat" />
	       	</form>
		</div>
	</div>
</body>
</html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>	
<script src="js/jquery.ui.selectmenu.js"></script>

<script src="js/jScrollPane/jquery.mousewheel.js"></script>
<script src="js/jScrollPane/jScrollPane.min.js"></script>
<script src="js/jquery-ui-1.8.20.custom.min.js"></script>
<script src="js/jquery.blockUI.js"></script>

<script src="js/script.js?r=<?= $rand ?>"></script>
<script type="text/javascript">
	$(function(){
		var deviceAgent = navigator.userAgent.toLowerCase();
		var agentIOS = deviceAgent.match(/(iphone|ipod|ipad)/);
		if (!agentIOS) {

			$('select#lang').selectmenu({style:'dropdown'});
			$('select#lang-from').selectmenu({style:'dropdown'});  
			$('select#lang-to').selectmenu({style:'dropdown'});

		}		
		
		$( "#accordion" ).accordion({ autoHeight: false });
	});
</script>

