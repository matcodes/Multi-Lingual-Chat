<?php

/* The Chat class exposes public static methods, used by ajax.php */

class Chat{
	public static function login($name,$email,$country,$oem,$oi,$op,$userip){
		if(!$name || !$email){
			throw new Exception('Fill in all the required fields.');
		}
		$gravatar = trim($email);
		
		$result = DB::query('SELECT * FROM oemusers WHERE oemkey = \'' . $oem . '\'');
	
	    $oemlabel = '';
	    $oemlang = '';
	    $oememail = '';
	    $oemlogo = '';
		while($oemserver = $result->fetch_object()){
			$oemlabel = $oemserver->oemlabel;
			$oemlang = $oemserver->oemlang;
			$oememail = $oemserver->oememail;
			$oemlogo = $oemserver->oemlogo;
		}

		$_SESSION['user']	= array(
			'name'		=> $name,
			'gravatar'	=> $gravatar,
			'country'	=> $country,
			'userID'	=> $gravatar
		);
		
		if ($oi)
			$op = 1;
		
		$room = Chat::addChatRoom("Help from " . $oemlabel,$oem . "," . $email,$oemlang,"Help from " . $oemlabel, $oem, $op, $userip, $gravatar);
		$rid = $room['roomID'];
/*
echo $room['roomID'] . '<br>';
echo $room['created'] . '<br>';
*/

		if ($room['created'] == 'true') {
			$url = "http://www.letzchat.com/oem/?id=oemtest&oi=oemtest&userip=" . urlencode($gravatar);

			$to = "wcrown@gmail.com";
			$subject = "A site user has initiated a new chat";

			$message = "
			<html>
			<head>
			<title>A site user has initiated a chat</title>
			</head>
			<body>
			<p>A site user has initiated a chat. Click the link below to chat with the client.</p>
			<p><a href='" . "http://www.letzchat.com/oem/?id=oemtest&u=" . $gravatar . "'>Chat</a></p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

			// More headers
			$headers .= 'From: LetzChat Sites <info@letzchat.com>' . "\r\n";
			$headers .= 'Bcc: bill@planethospital.com' . "\r\n";

			mail($to,$subject,$message,$headers);
		}

		if ($oi) {
			$name = $oemlabel;
			$email = $oi;
			$gravatar = $oi;
		}

		$user = new ChatUser(array(
			'name'		=> $name,
			'gravatar'	=> $gravatar,
			'country'	=> $country,
			'room'		=> $rid,
			'oem'		=> $oem
		));
		$userID = $user->save()->insert_id;

		$_SESSION['user']	= array(
			'name'		=> $name,
			'gravatar'	=> $gravatar,
			'country'	=> $country,
			'userID'	=> $gravatar,
			'room'		=> $rid
		);

		return array(
			'status'	=> 1,
			'name'		=> $name,
			'gravatar'	=> $gravatar,
			'country'	=> $country,
			'userID'	=> $gravatar,
			'oemlabel'  => $oemlabel,
			'oemlang' 	=> $oemlang,
			'oememail'	=> $oememail,
			'oemlogo'	=> $oemlogo,
			'room'		=> $rid
		);
		
	}
	
	public static function checkLogged(){
		$response = array('logged' => false);
			
		if($_SESSION['user']['name']) {
			$response['logged'] = true;
			$response['loggedAs'] = array(
				'name'		=> $_SESSION['user']['name'],
				'gravatar'	=> $_SESSION['user']['gravatar'],
				'country'	=> $_SESSION['user']['country'],  
				'oem'		=> $_SESSION['user']['oem'],
				'userID'	=> $_SESSION['user']['userID']
			);
		}
		
		return $response;
	}
	
	public static function logout(){
		$qry = "SELECT id FROM webchat_rooms WHERE type = 'P' AND owner = '" . DB::esc($_SESSION['user']['userID']) . "'";
		$room = DB::query($qry)->fetch_object()->room;
		if ($room) {
			DB::query("DELETE FROM webchat_room_users WHERE room = '".DB::esc($room)."'");
			DB::query("DELETE FROM webchat_rooms WHERE type = 'P' AND room = '".DB::esc($room)."'");
		}
		
//		DB::query("DELETE FROM webchat_users WHERE name = '".DB::esc($_SESSION['user']['name'])."'");
		
		$_SESSION = array();
		unset($_SESSION);

		return array('status' => 1);
	}

	public static function submitChat($chatText,$chatRoom,$curLang,$country,$to){
		if($_SESSION['user']['userID']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name'], 'gravatar' => $_SESSION['user']['userID'], 'country' => $_SESSION['user']['country'], 'room' => $chatRoom));
			$user->update();
		}
		
		if(!$_SESSION['user']){
			throw new Exception('You are not logged in');
		}
		
		if(!$chatText){
			throw new Exception('You haven\' entered a chat message.');
		}
	
		$type = "A";
		if ($to)
			$type="P";
	
		$chat = new ChatLine(array(
			'author'	=> $_SESSION['user']['name'],
			'gravatar'	=> $_SESSION['user']['gravatar'],
			'text'		=> $chatText,
			'room'		=> $chatRoom,
			'language'	=> $curLang,
			'country'	=> $country,
			'to' 		=> $to,
			'type'		=> $type
		));
	
		// The save method returns a MySQLi object
		$insertID = $chat->save()->insert_id;
	
		return array(
			'status'	=> 1,
			'insertID'	=> $insertID
		);
	}
	
	public static function addChatRoom($name,$users,$lang,$note,$oi,$op,$userip,$gravatar){	
		$qry = 'SELECT * FROM webchat_users WHERE oem = 1 AND oemserver = \'' . $oi . '\' AND gravatar = \'' . $gravatar . '\' OR gravatar = \'' . $userip . '\'';
//echo $qry . '<br>';		
		$result = DB::query($qry);
		while($oemuser = $result->fetch_object()){
			return array(
				'roomID' => $oemuser->room,
				'created' => 'false'
			);
		}

		$result = DB::query('SELECT * FROM oemusers WHERE oemkey = \'' . $oem . '\'');
	
	    $oemlabel = '';
	    $oemlang = '';
	    $oememail = '';
	    $oemlogo = '';
		while($oemserver = $result->fetch_object()){
			$oemlabel = $oemserver->oemlabel;
			$oemlang = $oemserver->oemlang;
			$oememail = $oemserver->oememail;
			$oemlogo = $oemserver->oemlogo;
		}
		
		if($_SESSION['user']['userID']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name'], 'gravatar' => $_SESSION['user']['userID'], 'country' => $_SESSION['user']['country'], 'room' => $chatRoom));
			$user->update();
		}
		
		if(!$name){
			throw new Exception('You haven\'t entered a Chat Topic.');
		}
		if(!$users){
			throw new Exception('You haven\t invited anyone into to chat with you.');
		}
	
		$trans = "";
		if ($lang != 'en') {
			$trans = Chat::translateText($name, 'en', 'gen');
		}
		else {
			$trans = $name;
		}
	
		$room = new ChatRoom(array(
			'name'	=> $trans,
			'owner'	=> $_SESSION['user']['userID'],
			'type'	=> 'O'
		));
	
		// The save method returns a MySQLi object
		$roomID = $room->save()->insert_id;

		$roomuser = new ChatRoomUser(array(
			'userID'	=> $_SESSION['user']['userID'],
			'room'	=> $roomID
		));
		$roomuser->save();
	
		$invitees = explode(",", $users);

/*
		foreach ($invitees as $invitee) {
			if($invitee) {			
				$roomuser = new ChatRoomUser(array(
					'userID'=> $invitee,
					'room'	=> $roomID
				));
				$roomuser->save();
			
				$cnote = "";
				if ($note) {
					"Creator added the following note: [+++N]" . $note . "[---N]";
				}
			
				//PM the invitee
//				Chat::submitChat("You have been invited to the private chat room: [ROOMLINKPLACEHOLDER]" . $name . "[ENDROOMLINKPLACEHOLDER].",$roomID,"","",$invitee );	
			}			
		}
*/		
		return array(
			'roomID' => $roomID,
			'created' => 'true'
		);
	}
	
	public static function changeRoom($chatRoom){
		if($_SESSION['user']['name']){
			$user = new ChatUser(array('gravatar' => $_SESSION['user']['userID'], 'name' => $_SESSION['user']['name'], 'country' => $_SESSION['user']['country'], 'room' => $chatRoom));
			$user->updateRoom();
		}
	}	
	
	public static function getUsers($chatRoom){
		if($_SESSION['user']['userID']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name'], 'gravatar' => $_SESSION['user']['userID'], 'country' => $_SESSION['user']['country'], 'room' => $chatRoom));
			$user->update();
		}
		
		if (!$chatRoom)
			$chatRoom = '1'; 
		
		// Deleting chats older than 5 minutes and users inactive for 30 seconds
		
		DB::query("DELETE FROM webchat_lines WHERE ts < SUBTIME(NOW(),'0:15:0')");
		
		//minor tests
//		DB::query("DELETE from webchat_room_users where room IN (SELECT id FROM `webchat_rooms` WHERE owner NOT IN (SELECT gravatar from webchat_users))");
//		DB::query("DELETE from `webchat_rooms` WHERE type = 'P' AND owner NOT IN (SELECT gravatar from webchat_users)");
		
		//loop through the users we're about to delete and punt the users and delete the room
		$qry = "SELECT id FROM webchat_users WHERE last_activity < SUBTIME(NOW(),'0:0:60')"; //Don't know why I was doing this:  room = " . DB::esc($chatRoom) . " AND
		$result = DB::query($qry);

		while($deluser = $result->fetch_object()){
			$deluserid = $deluser->id;
			$qry = "SELECT id FROM webchat_rooms WHERE type = 'P' AND owner = '" . DB::esc($deluserid) . "'";
			$room = DB::query($qry)->fetch_object()->room;
			if ($room) {
				DB::query("DELETE FROM webchat_room_users WHERE room = '".DB::esc($room)."'");
				DB::query("DELETE FROM webchat_rooms WHERE type = 'P' AND room = '".DB::esc($room)."'");
			}
		}		
//		DB::query("DELETE FROM webchat_users WHERE last_activity < SUBTIME(NOW(),'0:0:30')"); //Don't know why I was doing this:  room = " . DB::esc($chatRoom) . " AND
		
		
		$result = DB::query('SELECT * FROM webchat_users WHERE room = ' . DB::esc($chatRoom) . ' ORDER BY name ASC');
		
		$users = array();
		$total = '0';
		if ($result) {
			while($user = $result->fetch_object()){
				$user->gravatar = $user->gravatar;
				$users[] = $user;
			}
			
			$total = DB::query('SELECT COUNT(*) as cnt FROM webchat_users WHERE room = ' . DB::esc($chatRoom))->fetch_object()->cnt;			
		}
	
		return array(
			'users' => $users,
			'total' => $total
		);
	}
	
	public static function getSystemTranslations($language){
		$qry = 'SELECT * FROM translations WHERE TYPE = \'S\' AND to_lang = \'' . DB::esc($language) . '\'';
		
		$result = DB::query($qry);  
		
		$trans = array();
		while($tran = $result->fetch_object()){
			$trans[] = $tran;
		}
	
		return array(
			'trans' => $trans
		);
	}

	public static function getAllUsers(){
		if($_SESSION['user']['userID']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name'], 'gravatar' => $_SESSION['user']['userID'], 'country' => $_SESSION['user']['country'], 'room' => $chatRoom));
			$user->update();
		}
		
		// Deleting chats older than 5 minutes and users inactive for 30 seconds
		$result = DB::query('SELECT * FROM webchat_users ORDER BY name ASC');
		
		$users = array();
		while($user = $result->fetch_object()){
			$user->userID = $user->gravatar;
			$user->gravatar = Chat::gravatarFromHash($user->gravatar,30);
			$users[] = $user;
		}
	
		return array(
			'users' => $users,
			'total' => DB::query('SELECT COUNT(*) as cnt FROM webchat_users')->fetch_object()->cnt
		);
	}
	
	public static function getRooms($lang){ //$ID
		if($_SESSION['user']['userID']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name'], 'gravatar' => $_SESSION['user']['userID'], 'country' => $_SESSION['user']['country'], 'room' => $chatRoom));
			$user->update();
		}
		
		$ID = $_SESSION['user']['userID'];
		$qry = "SELECT * FROM webchat_rooms wr WHERE wr.owner = '" . $ID ."' OR (wr.type = 'S' AND wr.master = 0) OR (wr.type = 'P' AND (SELECT count(*) FROM webchat_room_users WHERE room = wr.id AND userID = '" . $ID . "') > 0) ORDER BY wr.name ASC";
		$result = DB::query($qry);
		$rooms = array();
		while($room = $result->fetch_object()){
			if ($lang == 'ar') {
				if (!$room->ar) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->ar = $room->trans;
				}
				else {
					$room->trans = $room->ar;
				}
			}
			else if ($lang == 'bg') {
				if (!$room->bg) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->bg = $room->trans;
				}
				else {
					$room->trans = $room->bg;
				}
			}
			else if ($lang == 'zhCHT') {
				if (!$room->zhCHT) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->zhCHT = $room->trans;
				}
				else {
					$room->trans = $room->zhCHT;
				}
			}
			else if ($lang == 'zhCHS') {
				if (!$room->zhCHS) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->zhCHS = $room->trans;
				}
				else {
					$room->trans = $room->zhCHS;
				}
			}
			else if ($lang == 'cs') {
				if (!$room->cs) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->cs = $room->trans;
				}
				else {
					$room->trans = $room->cs;
				}
			}
			else if ($lang == 'da') {
				if (!$room->da) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->da = $room->trans;
				}
				else {
					$room->trans = $room->da;
				}
			}
			else if ($lang == 'nl') {
				if (!$room->nl) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->nl = $room->trans;
				}
				else {
					$room->trans = $room->nl;
				}
			}
			else if ($lang == 'en') {
				if (!$room->en) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->en = $room->trans;
				}
				else {
					$room->trans = $room->en;
				}
			}
			else if ($lang == 'et') {
				if (!$room->et) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->et = $room->trans;
				}
				else {
					$room->trans = $room->et;
				}
			}
			else if ($lang == 'zl') {
				if (!$room->zl) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->zl = $room->trans;
				}
				else {
					$room->trans = $room->zl;
				}
			}
			else if ($lang == 'fr') {
				if (!$room->fr) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->fr = $room->trans;
				}
				else {
					$room->trans = $room->fr;
				}
			}
			else if ($lang == 'fi') {
				if (!$room->fi) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->fi = $room->trans;
				}
				else {
					$room->trans = $room->fi;
				}
			}
			else if ($lang == 'de') {
				if (!$room->de) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->de = $room->trans;
				}
				else {
					$room->trans = $room->de;
				}
			}
			else if ($lang == 'el') {
				if (!$room->el) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->el = $room->trans;
				}
				else {
					$room->trans = $room->el;
				}
			}
			else if ($lang == 'ht') {
				if (!$room->ht) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->ht = $room->trans;
				}
				else {
					$room->trans = $room->ht;
				}
			}
			else if ($lang == 'he') {
				if (!$room->he) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->he = $room->trans;
				}
				else {
					$room->trans = $room->he;
				}
			}
			else if ($lang == 'hi') {
				if (!$room->hi) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->hi = $room->trans;
				}
				else {
					$room->trans = $room->hi;
				}
			}
			else if ($lang == 'hu') {
				if (!$room->hu) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->hu = $room->trans;
				}
				else {
					$room->trans = $room->hu;
				}
			}
			else if ($lang == 'hww') {
				if (!$room->hww) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->hww = $room->trans;
				}
				else {
					$room->trans = $room->hww;
				}
			}
			else if ($lang == 'it') {
				if (!$room->it) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->it = $room->trans;
				}
				else {
					$room->trans = $room->it;
				}
			}
			else if ($lang == 'ja') {
				if (!$room->ja) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->ja = $room->trans;
				}
				else {
					$room->trans = $room->ja;
				}
			}
			else if ($lang == 'ko') {
				if (!$room->ko) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->ko = $room->trans;
				}
				else {
					$room->trans = $room->ko;
				}
			}
			else if ($lang == 'lv') {
				if (!$room->lv) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->lv = $room->trans;
				}
				else {
					$room->trans = $room->lv;
				}
			}
			else if ($lang == 'lt') {
				if (!$room->lt) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->lt = $room->trans;
				}
				else {
					$room->trans = $room->lt;
				}
			}
			else if ($lang == 'no') {
				if (!$room->no) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->no = $room->trans;
				}
				else {
					$room->trans = $room->no;
				}
			}
			else if ($lang == 'pl') {
				if (!$room->pl) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->pl = $room->trans;
				}
				else {
					$room->trans = $room->pl;
				}
			}
			else if ($lang == 'pt') {
				if (!$room->pt) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->pt = $room->trans;
				}
				else {
					$room->trans = $room->pt;
				}
			}
			else if ($lang == 'ro') {
				if (!$room->ro) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->ro = $room->trans;
				}
				else {
					$room->trans = $room->ro;
				}
			}
			else if ($lang == 'ru') {
				if (!$room->ru) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->ru = $room->trans;
				}
				else {
					$room->trans = $room->ru;
				}
			}
			else if ($lang == 'sk') {
				if (!$room->sk) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->sk = $room->trans;
				}
				else {
					$room->trans = $room->sk;
				}
			}
			else if ($lang == 'sl') {
				if (!$room->sl) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->sl = $room->trans;
				}
				else {
					$room->trans = $room->sl;
				}
			}
			else if ($lang == 'es') {
				if (!$room->es) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->es = $room->trans;
				}
				else {
					$room->trans = $room->es;
				}
			}
			else if ($lang == 'sv') {
				if (!$room->sv) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->sv = $room->trans;
				}
				else {
					$room->trans = $room->sv;
				}
			}
			else if ($lang == 'th') {
				if (!$room->th) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->th = $room->trans;
				}
				else {
					$room->trans = $room->th;
				}
			}
			else if ($lang == 'tr') {
				if (!$room->tr) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->tr = $room->trans;
				}
				else {
					$room->trans = $room->tr;   
				}
			}
			else if ($lang == 'uk') {
				if (!$room->uk) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->uk = $room->trans;
				}
				else {
					$room->trans = $room->uk;   
				}
			}
			else if ($lang == 'vi') {
				if (!$room->vi) {
					$room->trans = Chat::translateText($room->name, $lang, 'room'); 
					$room->vi = $room->trans;
				}
				else {
					$room->trans = $room->vi;   
				}
			}
			
			$qry1 = "SELECT * FROM webchat_rooms wr WHERE wr.type = 'S' AND wr.master = " . $room->id . " ORDER BY wr.name ASC";
			$result1 = DB::query($qry1);
			$subrooms = array();
			while($subroom = $result1->fetch_object()){
				if ($lang == 'ar') {
					if (!$subroom->ar) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->ar = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->ar;
					}
				}
				else if ($lang == 'bg') {
					if (!$subroom->bg) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->bg = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->bg;
					}
				}
				else if ($lang == 'zhCHT') {
					if (!$subroom->zhCHT) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->zhCHT = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->zhCHT;
					}
				}
				else if ($lang == 'zhCHS') {
					if (!$subroom->zhCHS) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->zhCHS = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->zhCHS;
					}
				}
				else if ($lang == 'cs') {
					if (!$subroom->cs) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->cs = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->cs;
					}
				}
				else if ($lang == 'da') {
					if (!$subroom->da) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->da = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->da;
					}
				}
				else if ($lang == 'nl') {
					if (!$subroom->nl) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->nl = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->nl;
					}
				}
				else if ($lang == 'en') {
					if (!$subroom->en) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->en = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->en;
					}
				}
				else if ($lang == 'et') {
					if (!$subroom->et) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->et = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->et;
					}
				}
				else if ($lang == 'zl') {
					if (!$subroom->zl) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->zl = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->zl;
					}
				}
				else if ($lang == 'fr') {
					if (!$subroom->fr) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->fr = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->fr;
					}
				}
				else if ($lang == 'fi') {
					if (!$subroom->fi) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->fi = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->fi;
					}
				}
				else if ($lang == 'de') {
					if (!$subroom->de) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->de = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->de;
					}
				}
				else if ($lang == 'el') {
					if (!$subroom->el) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->el = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->el;
					}
				}
				else if ($lang == 'ht') {
					if (!$subroom->ht) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->ht = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->ht;
					}
				}
				else if ($lang == 'he') {
					if (!$subroom->he) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->he = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->he;
					}
				}
				else if ($lang == 'hi') {
					if (!$subroom->hi) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->hi = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->hi;
					}
				}
				else if ($lang == 'hu') {
					if (!$subroom->hu) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->hu = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->hu;
					}
				}
				else if ($lang == 'hww') {
					if (!$subroom->hww) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->hww = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->hww;
					}
				}
				else if ($lang == 'it') {
					if (!$subroom->it) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->it = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->it;
					}
				}
				else if ($lang == 'ja') {
					if (!$subroom->ja) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->ja = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->ja;
					}
				}
				else if ($lang == 'ko') {
					if (!$subroom->ko) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->ko = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->ko;
					}
				}
				else if ($lang == 'lv') {
					if (!$subroom->lv) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->lv = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->lv;
					}
				}
				else if ($lang == 'lt') {
					if (!$subroom->lt) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->lt = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->lt;
					}
				}
				else if ($lang == 'no') {
					if (!$subroom->no) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->no = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->no;
					}
				}
				else if ($lang == 'pl') {
					if (!$subroom->pl) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->pl = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->pl;
					}
				}
				else if ($lang == 'pt') {
					if (!$subroom->pt) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->pt = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->pt;
					}
				}
				else if ($lang == 'ro') {
					if (!$subroom->ro) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->ro = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->ro;
					}
				}
				else if ($lang == 'ru') {
					if (!$subroom->ru) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->ru = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->ru;
					}
				}
				else if ($lang == 'sk') {
					if (!$subroom->sk) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->sk = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->sk;
					}
				}
				else if ($lang == 'sl') {
					if (!$subroom->sl) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->sl = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->sl;
					}
				}
				else if ($lang == 'es') {
					if (!$subroom->es) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->es = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->es;
					}
				}
				else if ($lang == 'sv') {
					if (!$subroom->sv) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->sv = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->sv;
					}
				}
				else if ($lang == 'th') {
					if (!$subroom->th) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->th = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->th;
					}
				}
				else if ($lang == 'tr') {
					if (!$subroom->tr) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->tr = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->tr;   
					}
				}
				else if ($lang == 'uk') {
					if (!$subroom->uk) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->uk = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->uk;   
					}
				}
				else if ($lang == 'vi') {
					if (!$subroom->vi) {
						$subroom->trans = Chat::translateText($subroom->name, $lang, 'room'); 
						$subroom->vi = $subroom->trans;
					}
					else {
						$subroom->trans = $subroom->vi;   
					}
				}

				//$room->trans = Chat::translateText($room->name, $lang, 'room'); 
				$subrooms[] = $subroom;
			}			
			
			$room->subrooms = $subrooms;
			
			
			
			
			//$room->trans = Chat::translateText($room->name, $lang, 'room'); 
			$rooms[] = $room;
		}
		
		return array(
			'rooms' => $rooms,
			'total' => DB::query("SELECT COUNT(*) as cnt FROM webchat_rooms WHERE type = 'P' OR type = 'S' ORDER BY name ASC")->fetch_object()->cnt
		);
	}

	public static function getChats($lastID,$lang,$room){
		$lastID = (int)$lastID;
		if (!$room)
			$room = '1';
	
		$qry = "SELECT * FROM webchat_lines WHERE id > ".$lastID." AND (room = ".$room." AND type = 'A' || (type = 'P' AND `to` = '" . $_SESSION['user']['userID'] . "')) ORDER BY id ASC";
		$result = DB::query($qry);
	
		$chats = array();
		while($chat = $result->fetch_object()){
			
			// Returning the GMT (UTC) time of the chat creation:
			
			$chat->time = array(
				'hours'		=> gmdate('H',strtotime($chat->ts)),
				'minutes'	=> gmdate('i',strtotime($chat->ts))
			);
			
			$chat->msgtype = $chat->type;
			
			$chat->trans = Chat::translateText($chat->text, $lang, 'chatline'); 
			
			//$chat->gravatar = Chat::gravatarFromHash($chat->gravatar);
			
			$chats[] = $chat;
		}
	
		return array('chats' => $chats);
	}

	public static function addTranslation($orig_text, $orig_lang, $to_text, $to_lang, $type){
		try {
		
			$hash = md5($orig_text . '_' . $orig_lang . '_' . $to_lang);
		
		
			if(!$_SESSION['user']){
				throw new Exception('You are not logged in');
			}
		
			if(!$orig_text){
				throw new Exception('Not enough information to translate.');
			}
	
			$trans = new Translations(array(
				'hash'	=> $hash,
				'orig_text'	=> $orig_text,
				'orig_lang'	=> $orig_lang,
				'to_text'	=> $to_text,
				'to_lang'	=> $to_lang,
				'type'		=> $type
			));
	
			// The save method returns a MySQLi object
			$trans->save();//->tid;
		}
		catch(Exception $e)
		{
			echo "Exception: " . $e->getMessage() . PHP_EOL;
		    
			throw new Exception('Message: ' . $e->getMessage());
		}
	}

	public static function addRoomTranslation($orig_text, $to_text, $to_lang){
		try {
			$qry = "UPDATE webchat_rooms SET " . $to_lang . " = '" . DB::esc($to_text) . "' WHERE name = '" . DB::esc($orig_text) . "'";
	 
			$update = DB::query($qry);
//			$a = $update->fetch_object();
		}
		catch(Exception $e)
		{
			echo "Exception: " . $e->getMessage() . PHP_EOL;
		    
			throw new Exception('Message: ' . $e->getMessage());
		}
	}

	public static function getTrans($orig_text,$orig_lang,$to_lang,$type){
		$hash = md5($orig_text . '_' . $orig_lang . '_' . $to_lang);
		
		if ($_SESSION[$hash]) {
			return $_SESSION[$hash];
		}
		
		$result = DB::query('SELECT * FROM translations WHERE hash = \''.DB::esc($hash).'\''); 
		if ($result) {
			$translation = $result->fetch_object();
			$res = $translation->to_text;
			if ($res) {
				if ($translation->type != $type) {
					$qry = "UPDATE translations SET type = '" . DB::esc($type) . "' WHERE hash = '" . DB::esc($hash) . "'";

					$update = DB::query($qry);
				}
				$_SESSION[$hash] = $res;
				return $res;
			}
			else {
				return '__empty__';
			}
		}
	
		return '__empty__';
	}

	public static function translateText($inputStr, $lang, $type) {
		try {
		    //Client ID of the application.
		    $clientID = "babelizer";
			//Client Secret key of the application.
			$clientSecret = "y1bg53ifNEtghQpsx7tae+zh18Ifg9WxFkOVMY2q4w4=";
		    //OAuth Url.
		    $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
		    //Application Scope Url
		    $scopeUrl     = "http://api.microsofttranslator.com";
		    //Application grant type
		    $grantType    = "client_credentials";

		    //Create the AccessTokenAuthentication object.
		    $authObj      = new AccessTokenAuthentication();
		    //Get the Access token.
		    $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
		    //Create the authorization Header string.
		    $authHeader = "Authorization: Bearer ". $accessToken;

		    //Create the Translator Object.
		    $translatorObj = new HTTPTranslator();

		    //HTTP Detect Method URL.
		    $detectMethodUrl = "http://api.microsofttranslator.com/V2/Http.svc/Detect?text=".urlencode($inputStr);

		    //Call the curlRequest.
		    $strResponse = $translatorObj->curlRequest($detectMethodUrl, $authHeader);

		    //Interprets a string of XML into an object.
		    $xmlObj = simplexml_load_string($strResponse);
		    foreach((array)$xmlObj[0] as $val){
		        $languageCode = $val;
		    }

		    /*
		     * Get the language Names from languageCodes.
		     */
		    $locale = $lang; //'en';
			if ($locale == $languageCode)
				return $inputStr;

			$transString = Chat::getTrans($inputStr,$languageCode,$locale,$type);
			if ($transString == '__empty__') {
			    //HTTP Translate Method URL.
			
				$l = $locale;
				if ($l == 'zhCHS')
					$l = 'zh-CHS';
				if ($l == 'zhCHT')
					$l = 'zh-CHT';
					
			    $translateMethodUrl = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=".urlencode($inputStr)."&from=".$languageCode."&to=".$l;

			    //Call the curlRequest.
			    $strResponse = $translatorObj->curlRequest($translateMethodUrl, $authHeader);

			    //Interprets a string of XML into an object.
			    $xmlObj = simplexml_load_string($strResponse);

			    foreach((array)$xmlObj[0] as $val){
			        $transString = $val;
			    }

				$hash = md5($transString . '_' . $languageCode . '_' . $locale);
				$_SESSION[$hash] = $transStrings;
 
				if ($type == 'room') {
					Chat::addRoomTranslation($inputStr, $transString, $locale);
				}
				else {
					Chat::addTranslation($inputStr, $languageCode, $transString, $locale, $type);
				}
			}
			else if ($type == 'room') {
				Chat::addRoomTranslation($inputStr, $transString, $locale);
			}
			
			return $transString; 

		} catch (Exception $e) {
		    echo "Exception: " . $e->getMessage() . PHP_EOL;
		}
	}
	
	public static function gravatarFromHash($hash, $size=23){
		//$fbimg = 'https://graph.facebook.com/' . $hash . '/picture/';
		$fbimg = 'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm';
		
		if (!$hash)
			$fbimg = '';
		
		return $fbimg;
	}
}

class AccessTokenAuthentication {
    /*
     * Get the access token.
     *
     * @param string $grantType    Grant type.
     * @param string $scopeUrl     Application Scope URL.
     * @param string $clientID     Application client ID.
     * @param string $clientSecret Application client ID.
     * @param string $authUrl      Oauth Url.
     *
     * @return string.
     */
    function getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl){
        try {
            //Initialize the Curl Session.
            $ch = curl_init();
            //Create the request Array.
            $paramArr = array (
                 'grant_type'    => $grantType,
                 'scope'         => $scopeUrl,
                 'client_id'     => $clientID,
                 'client_secret' => $clientSecret
            );
            //Create an Http Query.//
            $paramArr = http_build_query($paramArr);
            //Set the Curl URL.
            curl_setopt($ch, CURLOPT_URL, $authUrl);
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
            //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //Execute the  cURL session.
            $strResponse = curl_exec($ch);
            //Get the Error Code returned by Curl.
            $curlErrno = curl_errno($ch);
            if($curlErrno){
                $curlError = curl_error($ch);
                throw new Exception($curlError);
            }
            //Close the Curl Session.
            curl_close($ch);
            //Decode the returned JSON string.
            $objResponse = json_decode($strResponse);
            if ($objResponse->error){
                throw new Exception($objResponse->error_description);
            }
            return $objResponse->access_token;
        } catch (Exception $e) {
            echo "Exception-".$e->getMessage();
        }
    }
}

/*
 * Class:HTTPTranslator
 * 
 * Processing the translator request.
 */
Class HTTPTranslator {
    /*
     * Create and execute the HTTP CURL request.
     *
     * @param string $url        HTTP Url.
     * @param string $authHeader Authorization Header string.
     * @param string $postData   Data to post.
     *
     * @return string.
     *
     */
    function curlRequest($url, $authHeader, $postData=''){
        //Initialize the Curl Session.
        $ch = curl_init();
        //Set the Curl url.
        curl_setopt ($ch, CURLOPT_URL, $url);
        //Set the HTTP HEADER Fields.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array($authHeader,"Content-Type: text/xml"));
        //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, False);
        if($postData) {
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        //Execute the  cURL session.
        $curlResponse = curl_exec($ch);
        //Get the Error Code returned by Curl.
        $curlErrno = curl_errno($ch);
        if ($curlErrno) {
            $curlError = curl_error($ch);
            throw new Exception($curlError);
        }
        //Close a cURL session.
        curl_close($ch);
        return $curlResponse;
    }

    /*
     * Create Request XML Format.
     *
     * @param string $languageCode  Language code
     *
     * @return string.
     */
    function createReqXML($languageCode) {
        //Create the Request XML.
        $requestXml = '<ArrayOfstring xmlns="http://schemas.microsoft.com/2003/10/Serialization/Arrays" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">';
        if($languageCode) {
            $requestXml .= "<string>$languageCode</string>";
        } else {
            throw new Exception('Language Code is empty.');
        }
        $requestXml .= '</ArrayOfstring>';
        return $requestXml;
    }
}

?>