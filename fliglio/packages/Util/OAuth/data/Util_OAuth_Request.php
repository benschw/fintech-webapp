<?php

class Util_OAuth_Request {
	
	private $token = null;
	
	private $method;
	private $url;
	private $consumer;
	private $callBack;
	private $signatureMethod;
	private $version;

	private $timestamp;
	private $nonce;
	
	private $params; // @todo: implement
	
	private $authParams = array();
	
	private $signature = null;
	
	private function __construct(Util_OAuth_Consumer $consumer, $method, $url, $signatureMethod, $version, $timestamp, $nonce, $params) {
		$this->consumer        = $consumer;

		$this->method          = $method;
		$this->url             = $url;
		$this->params          = $params;
		
		$this->signatureMethod = $signatureMethod;
		$this->version         = $version;
		
		$this->timestamp       = $timestamp;
		$this->nonce           = $nonce;
		
		$this->setAttribute("oauth_consumer_key", $this->consumer->getKey());
		
		$this->setAttribute('oauth_timestamp', $this->timestamp);
		$this->setAttribute('oauth_nonce', $this->nonce);

		$this->setAttribute('oauth_version', $this->version);


		$this->setAttribute('oauth_signature_method', $signatureMethod);
	}
	
	public static function getNewRequest(Util_OAuth_Consumer $consumer, $method, $url, $signatureMethod, $version, $params = array()) {
		$request = new self(
			$consumer, $method, $url, 
			$signatureMethod, 
			$version,
			Util_OAuth_Util::generateTimestamp(), 
			Util_OAuth_Util::generateNonce(), 
			$params
		);
		
		return $request;
	}
	
	/**
	 * undocumented function
	 *
	 * $authHeader example:
	 * <code>
	 *   # split into multiple lines for readability
	 *   OAuth 
	 *   oauth_consumer_key=bvi,
	 *   oauth_timestamp=1282306615,
	 *   oauth_nonce=c095c89d85b71880f0b30389bc7f477e,
	 *   oauth_version=1.0,
	 *   oauth_signature_method=HMAC-SHA1,
	 *   oauth_callback=http%3A%2F%2Fwww.example.com%2Fcallback-url,
	 *   oauth_signature=Ayr%2BogxGGJFaq%2FVhpmrsCrDeG7Q%3D.
	 * </code>
	 *
	 * @param string $method 
	 * @param string $url 
	 * @param string $authHeader 
	 * @param array $params 
	 * @return Util_OAuth_Request
	 */
	public static function getFromAuthHeader(Util_OAuth_Consumer $consumer, $method, $url, $authHeader, $params = array()) {
		$authParams = Util_OAuth_Util::parseAuthHeader($authHeader);
		
		if (!isset($authParams['oauth_consumer_key'])) {
			throw new Util_OAuth_BadRequestException("'oauth_consumer_key' must be set");
		}

		$request = new self(
			$consumer, $method, $url, 
			$authParams['oauth_signature_method'], 
			$authParams['oauth_version'], 
			$authParams['oauth_timestamp'], 
			$authParams['oauth_nonce'], 
			$params
		);
		
		$request->setSignature($authParams['oauth_signature']);
		
		if (isset($authParams['oauth_callback'])) {
			$request->setCallBack($authParams['oauth_callback']);
		}
		
		if (isset($authParams['oauth_token'])) {
			$request->setToken(new Util_OAuth_Token($authParams['oauth_token']));
		}
		if (isset($authParams['oauth_verifier'])) {
			$request->setVerifier($authParams['oauth_verifier']);
		}
		
		return $request;
	}

	public function getConsumer() {
		return $this->consumer;
	}
	
	public function getToken() {
		return $this->token;
	}
	public function setToken($token) {
		$this->token = $token;
		$this->setAttribute('oauth_token', $this->token->getKey());
	}
	public function setVerifier($verifier) {
		$this->setAttribute('oauth_verifier', $verifier);
	}
	
	/* Optional Auth Parameters */
	public function setCallBack($callBack) {
		$this->callBack = $callBack;
		$this->setAttribute("oauth_callback", $this->callBack);
	}
	public function getCallBack() {
		return $this->callBack;
	}
	
	public function setSignature($signature) {
		$this->signature = $signature;
		$this->setAttribute("oauth_signature", $this->signature);
		
	}
	public function getSignature() {
		return $this->signature;
	}
	
	/* ======================= */
	
	public function getMethod() {
		return $this->method;
	}
	public function getUrl() {
		return $this->url;
	}
	public function getParams() {
		return $this->params;
	}
	public function getNonce() {
		return $this->nonce;
	}
	
	public function getTimestamp() {
		return $this->timestamp;
	}
	
	
	public function generateSignature($token = null) {
		$token = is_null($token) ? $this->token : $token;
		return Util_OAuth_SignatureUtil::generate($this, $token);//$this->consumer, $this->token, $this->method, $this->url, $this->getSignableAuthParams());
	}
	
	public function getAuthorizationHeader() {
		return Util_OAuth_Util::buildAuthHeader($this->authParams);
	}
	
	
	
	public function getSignableAuthParams() {
		$params = $this->authParams;
		unset($params['oauth_signature']);
		return $params;
	}
	
	private function setAttribute($key, $value) {
		$this->authParams[$key] = $value;
	}


}