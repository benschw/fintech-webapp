<?php

class Svc_Dwolla_Services extends Svc_Dwolla_Service {
	
	public function sendTransaction($amount, $pin, $destinationId) {
		$body = array(
			"oauth_token"   => "",
			"pin"           => $pin,
			"destinationId" => $destinationId,
			"amount"        => $amount
		);
		
		$this->makeRequest('/oauth/rest/transactions/send', $body);
	}
}