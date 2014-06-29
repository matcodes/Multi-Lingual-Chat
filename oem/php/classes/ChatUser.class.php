<?php

class ChatUser extends ChatBase{
	
	protected $name = '', $gravatar = '', $country = '', $room = '', $oem = '', $oemenable = '1';
	
	public function save(){
		if (!$room || $room == '0')
			$room = '1';
		
		DB::query("
			INSERT INTO webchat_users (name, gravatar, country, room, oem, oemserver)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->country)."',
				'".DB::esc($this->room)."',
				'".DB::esc($this->oemenable)."',
				'".DB::esc($this->oem)."'
		) ON DUPLICATE KEY UPDATE oemserver='".DB::esc($this->oem)."',oem = 1,last_activity = NOW(), room = '".DB::esc($this->room)."'");
		
		return DB::getMySQLiObject();
	}
	
	public function update(){
		if (!$room || $room == '0')
			$room = '1';
		
		DB::query("
			INSERT INTO webchat_users (name, gravatar, country, oem, oemserver)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->country)."',
				'".DB::esc($oemenable)."',
				'".DB::esc($this->oem)."'
				
			) ON DUPLICATE KEY UPDATE last_activity = NOW(), room = '".DB::esc($this->room)."'");
	}
	
	public function updateRoom(){
		if (!$room || $room == '0')
			$room = '1';
		
		$qry = "
			INSERT INTO webchat_users (name, gravatar, country, room, last_activity, oem, oemserver)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->country)."',
				'".DB::esc($this->room)."',
				NOW(),
				'".DB::esc($oemenable)."',
				'".DB::esc($this->oem)."'
				
			) ON DUPLICATE KEY UPDATE last_activity = NOW(), room = '".DB::esc($this->room)."'";
		
		DB::query($qry);
		
		return array('response' => '1', 'bees' => 'hive'); 
	}
}

?>