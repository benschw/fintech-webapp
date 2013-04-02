<?php

class FlMon_Logstash_JsonEntry implements FlMon_Logstash_Publishable {
	private $arr;
	public function __construct(array $arr) {
		$this->arr = $arr;
	}
	
	public function toEntryString() {
		return json_encode($this->arr);
	}
}