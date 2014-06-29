<?php

/* Database Configuration. Add your details below */

$dbOptions = array(
	'db_host' => 'babelizer2.db.8551816.hostedresource.com',
	'db_user' => 'babelizer2',
	'db_pass' => 'Thx!6591085z',
	'db_name' => 'babelizer2'
);

/* Database Config End */


error_reporting(E_ALL ^ E_NOTICE);

require "classes/DB.class.php";
require "classes/Chat.class.php";
require "classes/ChatBase.class.php";
require "classes/ChatLine.class.php";
require "classes/ChatUser.class.php";
require "classes/ChatRoom.class.php";
require "classes/ChatRoomUser.class.php";
require "classes/Translations.class.php";

session_name('webchat');
session_start();

if(get_magic_quotes_gpc()){
	
	// If magic quotes is enabled, strip the extra slashes
	array_walk_recursive($_GET,create_function('&$v,$k','$v = stripslashes($v);'));
	array_walk_recursive($_POST,create_function('&$v,$k','$v = stripslashes($v);'));
}

try{
	
	// Connecting to the database
	DB::init($dbOptions);
	
	$response = array();
	
	// Handling the supported actions:
	
	switch($_GET['action']){
		
		case 'login':
			$response = Chat::login($_GET['name'],$_GET['email'],$_GET['country']);
		break;
		
		case 'checkLogged':
			$response = Chat::checkLogged();
		break;
		
		case 'changeRoom':
			$response = Chat::changeRoom($_GET['room']);
		break;
		
		case 'logout':
			$response = Chat::logout();
		break;
		
		case 'submitChat':
			$response = Chat::submitChat($_POST['chatText'],$_POST['chatRoom'],$_POST['curLang'],$_POST['country'],$_POST['to']);
//$response = Chat::submitChat($_GET['chatText'],$_GET['chatRoom'],$_GET['curLang'],$_GET['country'],$_GET['to']);
		break;
		
		case 'getUsers':
			$response = Chat::getUsers($_GET['chatRoom']);
		break;

		case 'getAllUsers':
			$response = Chat::getAllUsers();
		break;
		
		case 'getChats':
			$response = Chat::getChats($_GET['lastID'],$_GET['lang'],$_GET['room']);
		break;

		case 'getRooms':
			$response = Chat::getRooms($_GET['lang']);
		break;

		case 'addChatRoom':
			$response = Chat::addChatRoom($_GET['name'],$_GET['users'],$_GET['lang'],$_GET['note']);
		break;

		case 'translateText':
			$response = Chat::translateText($_GET['text'],$_GET['lang'],$_GET['type']);
		break;
		
		case 'getSystemTranslations' :
			$response = Chat::getSystemTranslations($_GET['language']);
		break;

		default:
			throw new Exception('Wrong action -- '.$_GET['action'] );
	}
	
	echo json_encode($response);
}
catch(Exception $e){
	die(json_encode(array('error' => $e->getMessage())));
}

?>