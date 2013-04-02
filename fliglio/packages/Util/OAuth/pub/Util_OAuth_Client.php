<?php

/**
 *
 * @package FlAuthLib
 */
class Util_OAuth_Client {
	
	const METHOD_POST = 'post';
	const METHOD_GET  = 'get';
	
	const SIG_METHOD_HMAC_SHA1 = 'HMAC-SHA1';
	
	const VERSION_1_0 = '1.0';

	private $oauthUrl;        // https://auth.bancvue.com
	private $oauthServiceUrl; // http://authsvc
	private $consumer;
	private $signatureMethod;
	private $version;
	
	private $request; // keep last request around for debugging
	
	public function __construct($oauthUrl, $oauthServiceUrl, Util_OAuth_Consumer $consumer, $signatureMethod = null, $version = null) {
		$this->oauthUrl        = $oauthUrl;
		$this->oauthServiceUrl = $oauthServiceUrl;

		$this->consumer = $consumer;

		$this->signatureMethod = !is_null($signatureMethod) ? $signatureMethod : self::SIG_METHOD_HMAC_SHA1;
		$this->version         = !is_null($version) ? $version : self::VERSION_1_0;
	
	}
	
	/**
	 * Retrieve Request object from previous call
	 * get request objected used to make previous curl call for debugging and
	 * unit tests
	 *
	 * @return Util_OAuth_Request
	 */
	public function getLastRequest() {
		if (is_null($this->request)) {
			throw new Exception("Request object is not set - there was no 'last request'");
		}
		return $this->request;
	}
	
	/**
	 * Get Unauthorized token from AuthService
	 *
	 * @param string $callBack  url to redirect to after token authorization completion
	 * @param string $method  get or post
	 * @return Util_OAuth_Token
	 */
	public function getRequestToken($callBack, $method = null) {
		$this->request = $this->getRequest($method, Util_OAuth_NameUtil::getRequestTokenUrl($this->oauthServiceUrl));
		
		$this->request->setCallBack($callBack);
		
		$respString = $this->makeRequest($this->request);

		// print "\nRequest Token Response: " . $respString;
		$resp = Util_OAuth_Util::parseParameters($respString);

		if (!isset($resp['oauth_callback_confirmed']) || !isset($resp['oauth_token']) || !isset($resp['oauth_token_secret'])){
			throw new Util_OAuth_BadRequestException("Response is missing attributes:\n" . $respString . "(end)");
		}
		return new Util_OAuth_Token($resp['oauth_token'], $resp['oauth_token_secret']);
	}
	
	public function getTokenAuthorizationUrl(Util_OAuth_Token $token) {
		return Util_OAuth_NameUtil::getAuthorizationUrl($this->oauthUrl, $token);
	}
	
	/**
	 * @todo implement verifier
	 * 
	 * @param Util_OAuth_Token $requestToken 
	 * @param string $verifier 
	 * @param string $method 
	 * @return void
	 */
	public function getAccessToken(Util_OAuth_Token $requestToken, $verifier=null, $method = null) {
		$this->request = $this->getRequest($method, Util_OAuth_NameUtil::getAccessTokenUrl($this->oauthServiceUrl));
		
		$this->request->setToken($requestToken);
		// if (!is_null($verifier)) {
		// 	$this->request->setVerifier($verifier);
		// }
		$respString = $this->makeRequest($this->request);

		// print "\nAccess Token Response: " . $respString;
		$resp = Util_OAuth_Util::parseParameters($respString);
		
		if (!isset($resp['oauth_token']) || !isset($resp['oauth_token_secret'])) {
			throw new Util_OAuth_BadRequestException($respString);
		}
 		return new Util_OAuth_Token($resp['oauth_token'], $resp['oauth_token_secret']);
	}


	public function callProtectedResource(Util_OAuth_Token $accessToken, $method, Web_Uri $uri, $params = array()) {		
		$url = Web_Uri::get($this->oauthServiceUrl)->join($uri);
		$this->request = $this->getRequest($method, $url, $params);
		$this->request->setToken($accessToken);
		
		return $this->makeRequest($this->request);
	}

	private function getRequest($method, $url, $params=array()) {
		$method = !is_null($method) ? $method : self::METHOD_POST;

		return Util_OAuth_Request::getNewRequest(
			$this->consumer, 
			$method,
			(string) $url,
			$this->signatureMethod, 
			$this->version,
			$params
		);
	}

	private function makeRequest(Util_OAuth_Request $request) {
		$request->setSignature($request->generateSignature());
		$curlMethod = null;
		if ($request->getMethod() == self::METHOD_POST) {
			$curlMethod = Web_Curl::METHOD_POST;
		} else if ($request->getMethod() == self::METHOD_GET) {
			$curlMethod = Web_Curl::METHOD_GET;
		}
		
		$response = new Web_CurlResponse();
		// error_log("curl request: " . $request->getUrl());
		Web_Curl::makeRequest(
			new Web_CurlRequest(
				$curlMethod,
				$request->getUrl(),
				$request->getParams(),
				array("Authorization: " . $request->getAuthorizationHeader())
			),
			$response
		);

		if ($response->getHttpCode() == 400) {
			throw new Util_OAuth_BadRequestException("Bad Request\n" . $response->getContent());
		}
		if ($response->getHttpCode() == 401) {
			throw new Util_OAuth_UnauthorizedException("Unauthorized\n" . $response->getContent());
		}
		
		if ($response->getErrorNumber()) {
			throw new Util_OAuth_RequestException(sprintf(
				"Error (%s) '%s' for '%s'", 
				$response->getErrorNumber(), $response->getErrorMessage(), $request->getUrl()
			));
		}
		if ($response->getHttpCode() != 200) {
			throw new Util_OAuth_RequestException(sprintf("Response HTTP Code '%s' for '%s'\n%s", $response->getHttpCode(), $request->getUrl(), $response->getContent()));
		}
		if ($response->getContent() == '') {
			throw new Util_OAuth_RequestException("Response Content Empty for ". $request->getUrl());
		}
		return $response->getContent();
	}
 
}