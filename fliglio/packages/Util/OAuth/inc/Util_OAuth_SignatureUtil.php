<?php

class Util_OAuth_SignatureUtil {

	public static function generate(Util_OAuth_Request $request, Util_OAuth_Token $token = null) {
		$consumer   = $request->getConsumer();
		$method     = $request->getMethod();
		$url        = $request->getUrl();
		$parameters = $request->getSignableAuthParams();

		$baseString = self::getSignatureBaseString($method, $url, $parameters);

		
		$signature = null;

		switch ($parameters['oauth_signature_method']) {
			case Util_OAuth_Client::SIG_METHOD_HMAC_SHA1 :
				$keyParts = array(
			      $consumer->getSecret(),
			      !is_null($token) ? $token->getSecret() : ""
			    );

			    $clean = Util_OAuth_Util::urlencode_rfc3986($keyParts);
			    $key = implode('&', $clean);
		    
				$signature = base64_encode(hash_hmac('sha1', $baseString, $key, true));
				break;
			default :
				throw new Util_OAuth_Exception(sprintf("Unknown Signature Method: '%s'", $parameters['oauth_signature_method']));
		}
		return $signature;
	}

	private static function getSignatureBaseString($method, $url, $parameters) {
		/* get rid of this since we are generating it 
		   (it will only exist when the server is checking the signature) */
		unset($parameters['oauth_signature']);
		
		/* Verify that a valid method is specified */
		$methodString = null;
		if ($method == Util_OAuth_Client::METHOD_POST) {
			$methodString = 'POST';
		} else if($method == Util_OAuth_Client::METHOD_GET) {
			$methodString = 'GET';
		}
		
		$baseArray = array($methodString, (string)$url, Util_OAuth_Util::buildHttpQuery($parameters));
		
		$cleanBaseArray = Util_OAuth_Util::urlencode_rfc3986($baseArray);

		return implode('&', $cleanBaseArray);
	}

}