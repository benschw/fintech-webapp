<?php

class FlMon_Logstash_GelfEntry extends GELFMessage implements FlMon_Logstash_Publishable {

	public function toEntryString() {
		return json_encode($this->toArray());
	}
}