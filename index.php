<?php
 
include_once "facebook.php";

//production
$facebook = new Facebook(array('appId'=>'373800562643193','secret'=>'b1196821be94e65d34d9d532a25c696d','cookie'=>true));

//development  
//$facebook = new Facebook(array('appId'=>'265851746845272','secret'=>'8e26a9a1cc53e4f19631e7796011da91','cookie'=>true));

$session = $facebook->getUser();
 
if(!$session){
    $url = $facebook->getLoginUrl(array('canvas'=>1,'fbconnect'=>0));
    echo "<p>Redirecting to permission request...</p>";
    echo "<script type=\"text/javascript\">top.location.href = '$url';</script>";  
}
else{
	$user_profile = $facebook->api('/me','GET');
    $friends = $facebook->api('me/friends');
    $number_of_friends = count($friends[data]);
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
		
/*	
	echo "<p>You:<img src=\"https://graph.facebook.com/" . $session . "/picture\" title=\"".$friends[data][$random][name]."\"></p>";
	echo "<p>&lt;img src=&quot;https://graph.facebook.com/" . $session . "/picture&quot; title=&quot;".$friends[data][$random][name]."&quot;&gt;</p>";
	
	echo "<p>Name: " . $user_profile['name'] . "</p>";
	
    echo "<p>You have $number_of_friends friends</p>";
    echo "<p>". $user_profile['name'] ." has a random friend name: <strong>".$friends[data][$random][name]."</strong></p>";
    echo "<p>Here is a picture of your random friend:</p>";    
	echo "<p><img src=\"https://graph.facebook.com/".$friends[data][$random][id]."/picture\" title=\"".$friends[data][$random][name]."\"></p>";
*/	
}
 
$rand = rand(1000000, 10000000);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:og="http://ogp.me/ns#"
	xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta property="fb:app_id" content="373800562643193" />
	<meta property="fb:admins" content="731331601"/>
	<meta property="og:title" content="Babelizer" />
	<meta property="og:description" content="Babelizer is an International Application that allows you to chat seamlessly around the world without the language barrier." />
	<meta property="og:image" content="http://www.letzchat.com/images/logo_medium.png" />
	<meta property="og:url" content="http://www.letzchat.com/" />
	
	<title>Babelizer</title>
	
	<link rel="stylesheet" href="css/reset.css" />
	<link href="themes/base/jquery.ui.selectmenu.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="css/excite-bike/jquery-ui-1.8.20.custom.css" />
	<link href="themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="css/style.css?r=<?= $rand ?>" />
	<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
	
</head>
<body>
<div id="content">
	<div id="header">
		<div id="logo">Babelizer</div>
			<div id="top-buttons">
		
			<div class="lang-select"><font id="select_language"></font>:	 		
					<select name="lang" id="lang">
						<option value="ar" <?=$curlang=='ar' ? 'selected=\"selected\"' : ''?>>Arabic 
						<option value="bg" <?=$curlang=='bg' ? 'selected=\"selected\"' : ''?>>Bulgarian 
						<!--option value="ca" <?=$curlang=='ca' ? 'selected=\"selected\"' : ''?>>Catalan </-->
						<option value="zhCHS" <?=($curlang=='zh' || $lang =='zh-CHS')  ? 'selected=\"selected\"' : ''?>>Chinese Simplified
						<option value="zhCHT" <?=$curlang=='zh-CHT' ? 'selected=\"selected\"' : ''?>>Chinese Traditional  
						<option value="cs" <?=$curlang=='cs' ? 'selected=\"selected\"' : ''?>>Czech 
						<option value="da" <?=$curlang=='da' ? 'selected=\"selected\"' : ''?>>Danish 
						<option value="nl" <?=$curlang=='nl' ? 'selected=\"selected\"' : ''?>>Dutch 
						<option value="en" <?=$curlang=='en' ? 'selected=\"selected\"' : ''?>>English 
						<option value="et" <?=$curlang=='et' ? 'selected=\"selected\"' : ''?>>Estonian 
						<option value="fi" <?=$curlang=='fi' ? 'selected=\"selected\"' : ''?>>Finnish 
						<option value="fr" <?=$curlang=='fr' ? 'selected=\"selected\"' : ''?>>French 
						<option value="de" <?=$curlang=='de' ? 'selected=\"selected\"' : ''?>>German 
						<option value="el" <?=$curlang=='el' ? 'selected=\"selected\"' : ''?>>Greek 
						<option value="ht" <?=$curlang=='ht' ? 'selected=\"selected\"' : ''?>>Haitian Creole 
						<option value="he" <?=$curlang=='he' ? 'selected=\"selected\"' : ''?>>Hebrew 
						<option value="hi" <?=$curlang=='hi' ? 'selected=\"selected\"' : ''?>>Hindi 
						<option value="hu" <?=$curlang=='hu' ? 'selected=\"selected\"' : ''?>>Hungarian
						<option value="it" <?=$curlang=='it' ? 'selected=\"selected\"' : ''?>>Italian    
						<option value="ja" <?=$curlang=='ja' ? 'selected=\"selected\"' : ''?>>Japanese 
						<option value="ko" <?=$curlang=='ko' ? 'selected=\"selected\"' : ''?>>Korean 
						<option value="lv" <?=$curlang=='lv' ? 'selected=\"selected\"' : ''?>>Latvian 
						<option value="lt" <?=$curlang=='lt' ? 'selected=\"selected\"' : ''?>>Lithuanian 
						<option value="no" <?=$curlang=='no' ? 'selected=\"selected\"' : ''?>>Norwegian 
						<option value="pl" <?=$curlang=='pl' ? 'selected=\"selected\"' : ''?>>Polish 
						<option value="pt" <?=$curlang=='pt' ? 'selected=\"selected\"' : ''?>>Portuguese 
						<option value="ro" <?=$curlang=='ro' ? 'selected=\"selected\"' : ''?>>Romanian 
						<option value="ru" <?=$curlang=='ru' ? 'selected=\"selected\"' : ''?>>Russian 
						<option value="sk" <?=$curlang=='sk' ? 'selected=\"selected\"' : ''?>>Slovak
						<option value="sl" <?=$curlang=='sl' ? 'selected=\"selected\"' : ''?>>Slovenian 
						<option value="es" <?=$curlang=='es' ? 'selected=\"selected\"' : ''?>>Spanish 
						<option value="sv" <?=$curlang=='sv' ? 'selected=\"selected\"' : ''?>>Swedish 
						<option value="th" <?=$curlang=='th' ? 'selected=\"selected\"' : ''?>>Thai 
						<option value="tr" <?=$curlang=='tr' ? 'selected=\"selected\"' : ''?>>Turkish	
						<option value="uk" <?=$curlang=='uk' ? 'selected=\"selected\"' : ''?>>Ukrainian
						<option value="vi" <?=$curlang=='vi' ? 'selected=\"selected\"' : ''?>>Vietnamese	
					</select>
			</div>
			<a href="javaScript:inviteFriends()" class="top-button"><font id="invite_friends"></font></a> 
		
		</div>
	</div>
	<div class="clear"></div>
	<div id="left-side-subpage">
		<div id="rooms-list">
			<div class="left-box-header">  
				<span id="ChatRoomLabel" style="width:120px !important"></span>
				<span><a href="javascript:openCR()" class="button-add">+</a></span>
			</div>
			<div class="left-box-content">
				<div id="accordion">
				</div> 
			</div>
		</div>
	</div>
	<div id="main-chat">
		<div class="main-chat-header" id=chatTopBar></div>
		<div class="main-chat-content" id="chatLineHolder">
			
			<div class="clear"></div>
		</div>
		<div id="main-chat-form">
   			<div class="tip"></div>
		
			<!--input type="text" class="main-chat-input"/><input type="submit" class="submit-button" /-->

	       	<form id="loginForm" method="post" action="">
	           	<input type="hidden" id="name" name="name" class="rounded" maxlength="16" value="<?=$user_profile['name'] ?>"/>
	           	<input type="hidden" id="email" name="email" class="rounded" value="<?=$session ?>"/>
	       	</form>

	       	<form id="submitForm" method="post" action="">
				<input type="hidden" id="chatRoom" name="chatRoom" value="1"/>
				<input type="hidden" id="curLang" name="curLang" value="<?=$curlang ?>"/>
				<input type="hidden" id="country" name="country" value="<?=$country ?>"/>
	            <input type="text" id="chatText" name="chatText" class="main-chat-input" maxlength="255" />
				<input type="submit" class="submit-button" id="SubmitButton" value="" />
	       	</form>
		</div>
	</div>
		<div id="right-side-subpage">
		<div id="online-list">
			<div class="box-header" id="ChatWithLabel"></div>
			<div class="box-content" id="chatUsers">
				
			</div>
		</div>
		<div id="translate">
	   		<form id="translateForm" method="post" action="">
			<div id="translate-from">
			<font id="From_Label">From</font>:
			<div class="translate-select">
				<select name="lang-from" id="lang-from">
					<option value="">Auto Detect 
					<option value="ar">Arabic 
					<option value="bg">Bulgarian 
					<!--option value="ca">Catalan </-->
					<option value="zhCHS">Chinese Simplified
					<option value="zhCHT">Chinese Traditional  
					<option value="cs">Czech 
					<option value="da">Danish 
					<option value="nl">Dutch 
					<option value="en">English 
					<option value="et">Estonian 
					<option value="fi">Finnish 
					<option value="fr">French 
					<option value="de">German 
					<option value="el">Greek 
					<option value="ht">Haitian Creole 
					<option value="he">Hebrew 
					<option value="hi">Hindi 
					<option value="hu">Hungarian
					<option value="it">Italian 
					<option value="ja">Japanese 
					<option value="ko">Korean 
					<option value="lv">Latvian 
					<option value="lt">Lithuanian 
					<option value="no">Norwegian 
					<option value="pl">Polish 
					<option value="pt">Portuguese 
					<option value="ro">Romanian 
					<option value="ru">Russian 
					<option value="sk">Slovak
					<option value="sl">Slovenian 
					<option value="es">Spanish 
					<option value="sv">Swedish 
					<option value="th">Thai 
					<option value="tr">Turkish	
					<option value="uk">Ukrainian
					<option value="vi">Vietnamese	
				</select>
			</div>
			<textarea id="instant_text"></textarea>
			</div>
			<div id="translate-to">
			<font id="To_Label">To</font>:
			<div class="translate-select">
				<select name="lang-to" id="lang-to">
					<option value="ar">Arabic 
					<option value="bg">Bulgarian 
					<!--option value="ca">Catalan </-->
					<option value="zhCHS">Chinese Simplified
					<option value="zhCHT">Chinese Traditional  
					<option value="cs">Czech 
					<option value="da">Danish 
					<option value="nl">Dutch 
					<option value="en">English 
					<option value="et">Estonian 
					<option value="fi">Finnish 
					<option value="fr">French 
					<option value="de">German 
					<option value="el">Greek 
					<option value="ht">Haitian Creole 
					<option value="he">Hebrew 
					<option value="hi">Hindi 
					<option value="hu">Hungarian
					<option value="it">Italian 
					<option value="ja">Japanese 
					<option value="ko">Korean 
					<option value="lv">Latvian 
					<option value="lt">Lithuanian 
					<option value="no">Norwegian 
					<option value="pl">Polish 
					<option value="pt">Portuguese 
					<option value="ro">Romanian 
					<option value="ru">Russian 
					<option value="sk">Slovak
					<option value="sl">Slovenian 
					<option value="es">Spanish 
					<option value="sv">Swedish 
					<option value="th">Thai 
					<option value="tr">Turkish	
					<option value="uk">Ukrainian
					<option value="vi">Vietnamese	
				</select>
			</div>
			<textarea id="instant_results"></textarea>
			</div>
			<input type="submit" class="button" id="InstantTranslateButton" value="" />
		</div>
		<!--div class="fb-like" data-href="http://www.letzchat.com" data-send="true" data-width="200" data-show-faces="false" url="http://www.letzchat.com" style="padding-top:20px"></div-->
		<div class="fb-like" data-href="http://www.facebook.com/BabelizerFans" data-send="false" data-width="200" data-show-faces="true" style="padding-top:20px"></div>
		</form>
	</div>
	
	<div class="clear"></div>
	<div id="footer">Babelizer is a division of LETZCHAT Inc, a California Corporation. For more information contact <a href="mailto:info@letzchat.com" target="_blank">info@letzchat.com</a></div>  
</div>

<div id="dialog-form" title="Create new Chat Topic">
	<form>
		<table cellspacing=0 cellpadding=0>
			<tr>
				<td width="1%">
					<strong><font id='create_new_topic'>Topic</font></strong>:&nbsp;
				</td>
				<td width="99%">
					<input type="text" name="roomname" id="roomname" class="rounded" style="height:23px;width:285px"/>
				</td>
			</tr>
			<tr>
				<td>
					<strong><font id='create_new_invite'>Invite</font></strong>:<br>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<div id="inviteUsers" class="box-content3" style="width:256px"></div>
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="wait_spin"></div>

<div id="fb-root"></div>

<input type="hidden" id="not_entered_chat_topic" value="You have not entered a topic."/>
<input type="hidden" id="not_selected_users" value="You have not selected any users."/>
<input type="hidden" id="invite_your_friends" value="Invite your friends from around the world to Babelizer and Chat away!"/>
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
<script src="http://connect.facebook.net/en_US/all.js?r=<?= $rand ?>"></script>
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

