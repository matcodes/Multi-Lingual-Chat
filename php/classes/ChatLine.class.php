<?php

/* Chat line is used for the chat entries */

class ChatLine extends ChatBase{
	
	protected $text = '', $author = '', $gravatar = '', $room = '', $language = '', $country = '', $type = '', $to = '';
	
	public function save(){
		$qry = "
			INSERT INTO webchat_lines (author, gravatar, text, room, language, country, type, `to`)
			VALUES (
				'".DB::esc($this->author)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->text)."',
				'".DB::esc($this->room)."',
				'".DB::esc($this->language)."',
				'".DB::esc($this->country)."',
				'".DB::esc($this->type)."',
				'".DB::esc($this->to)."'
		)";
		
//echo $qry . "<br>";		
		
		DB::query($qry);
		
		// Returns the MySQLi object of the DB class
		
		return DB::getMySQLiObject();
	}
}

?>