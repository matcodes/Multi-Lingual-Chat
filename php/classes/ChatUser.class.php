<?php

class ChatUser extends ChatBase{
	
	protected $name = '', $gravatar = '', $country = '', $room = '';
	
	public function save(){
		if (!$room || $room == '0')
			$room = '1';
		
		DB::query("
			INSERT INTO webchat_users (name, gravatar, country, room)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->country)."',
				'".DB::esc($this->room)."'
		) ON DUPLICATE KEY UPDATE last_activity = NOW(), room = '".DB::esc($this->room)."'");
		
		return DB::getMySQLiObject();
	}
	
	public function update(){
		if (!$room || $room == '0')
			$room = '1';
		
		DB::query("
			INSERT INTO webchat_users (name, gravatar, country)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->country)."'
			) ON DUPLICATE KEY UPDATE last_activity = NOW(), room = '".DB::esc($this->room)."'");
	}
	
	public function updateRoom(){
		if (!$room || $room == '0')
			$room = '1';
		
		$qry = "
			INSERT INTO webchat_users (name, gravatar, country, room, last_activity)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->country)."',
				'".DB::esc($this->room)."',
				NOW()
			) ON DUPLICATE KEY UPDATE last_activity = NOW(), room = '".DB::esc($this->room)."'";
		
		DB::query($qry);
		
		return array('response' => '1', 'bees' => 'hive'); 
	}
}

?>