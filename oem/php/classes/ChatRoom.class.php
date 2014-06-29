<?php

/* Chat line is used for the chat entries */

class ChatRoom extends ChatBase{
	
	protected $name = '', $type = '', $owner = '';
	
	public function save(){
		$qry = "
			INSERT INTO webchat_rooms (name, en, type, owner)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->name)."',
				'".DB::esc($this->type)."',
				'".DB::esc($this->owner)."'
		)";
		
		DB::query($qry);
		
		// Returns the MySQLi object of the DB class
		
		return DB::getMySQLiObject();
	}
}

?>