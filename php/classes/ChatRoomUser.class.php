<?php

/* Chat line is used for the chat entries */

class ChatRoomUser extends ChatBase{
	
	protected $userID = '', $room = '';
	
	public function save(){
		$qry = "
			INSERT INTO webchat_room_users (userID, room)
			VALUES (
				'".DB::esc($this->userID)."',
				'".DB::esc($this->room)."'
		)";
		DB::query($qry);
		
		// Returns the MySQLi object of the DB class
		
		return DB::getMySQLiObject();
	}
}

?>