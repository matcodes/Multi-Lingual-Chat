<?php

/* Translations is used for the chat entries */

class Translations extends ChatBase{
	
	protected $hash = '', $orig_text = '', $orig_lang = '', $to_text = '', $to_lang = '', $type = '';
	
	public function save(){
		DB::query("
			INSERT INTO translations (hash, orig_text, orig_lang, to_text, to_lang, type)
			VALUES (
				'".DB::esc($this->hash)."',
				'".DB::esc($this->orig_text)."',
				'".DB::esc($this->orig_lang)."',
				'".DB::esc($this->to_text)."',
				'".DB::esc($this->to_lang)."',
				'".DB::esc($this->type)."'
		)");
		
		// Returns the MySQLi object of the DB class
		
		return DB::getMySQLiObject();
	}
}

?>