<?php

interface Util_Mail_MailDriver {

	public function setSubject($subj);
	public function addBody(Util_Mail_Body $body);
	public function addTo($email, $name=null);
	public function setFrom($email, $name=null);
	public function setReplyTo($email, $name=null);
	public function send();
}