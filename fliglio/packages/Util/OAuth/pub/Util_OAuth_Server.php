<?php
/**
 * 
 *
 * @package FlAuthLib
 */
class Util_OAuth_Server {

	private $isValid = false;
	
	protected $request;
	protected $dataStore;

	private $callBackConfirmed;

	private $requestToken;
	
	public function __construct(Util_OAuth_DataStore $dataStore, Util_OAuth_Request $request=null) {
		$this->dataStore = $dataStore;
		$this->request   = $request;
		if (!is_null($request)) {
			try {
				$this->dataStore->registerNonce($this->request->getNonce(), $this->request->getTimestamp());
			} catch (Util_OAuth_DuplicateNonceException $e) {
				throw new Util_OAuth_UnauthorizedException("Nonce must be unique.");
			}
		}
	}
	public function isRequestTokenValid(Util_OAuth_Token $token) {
		try {
			$this->dataStore->getRequestToken($token->getKey());
			return true;
		} catch (Util_OAuth_BadTokenException $e) {
			return false;
		}
	}
	public function isAccessTokenValid(Util_OAuth_Token $token) {
		try {
			$this->dataStore->getAccessToken($token->getKey());
			return true;
		} catch (Util_OAuth_BadTokenException $e) {
			return false;
		}
	}

	public function getRequestTokenResponse() {
		$this->validate();
		$requestToken = Util_OAuth_Token::getNew();
		$this->dataStore->registerRequestToken($requestToken);
		$this->dataStore->registerCallback($requestToken, $this->request->getCallBack());
		
		return Util_OAuth_Util::buildHttpQuery(array(
			'oauth_token'              => $requestToken->getKey(),
			'oauth_token_secret'       => $requestToken->getSecret(),
			'oauth_callback_confirmed' => $this->request->getCallBack() != '' ? 'true' : 'false'
		));
	}

	/**
	 * AuthorizeRequestToken
	 * 
	 * @todo implement returning oauth token & verifier
	 * 
	 * @param Util_OAuth_Token $token 
	 * @return void
	 */
	public function authorizeToken(Util_OAuth_Token $token) {
		$this->dataStore->authorizeToken($token);
	}
		
	public function getCallback(Util_OAuth_Token $token) {
		$callBack = $this->dataStore->getCallback($token);
		return $callBack;
		$query = Util_OAuth_Util::buildHttpQuery(array(
			'oauth_token'    => $token->getKey(),
			'oauth_verifier' => $this->dataStore->getVerifier($token)
		));
		$callBack .= "?" . $query;
		return $callBack;
	}

	/*
	 * The request signature has been successfully verified.
	 * The Request Token has never been exchanged for an Access Token.
	 * The Request Token matches the Consumer Key.
	 */
	public function exchangeRequestToken() {
		$this->validate(
			$this->dataStore->getRequestToken(
				$this->request->getToken()->getKey()
			)
		);
		
		try {
			return $this->dataStore->exchangeRequestToken($this->request->getToken());
		} catch (Util_OAuth_Exception $e) {
			throw new Util_OAuth_UnauthorizedException($e->getMessage());
		}
	}
	
	public function getAccessTokenResponse(Util_OAuth_Token $accessToken) {
		return Util_OAuth_Util::buildHttpQuery(array(
			'oauth_token'        => $accessToken->getKey(),
			'oauth_token_secret' => $accessToken->getSecret()
		));
	}
	
	public function deleteAccessToken(Util_OAuth_Token $token) {
		$this->dataStore->deleteAccessToken($token);
	}
	
	public function validateAccessToken() {
		$token = $this->request->getToken();
		if (!$token instanceof Util_OAuth_Token) {
			throw new Exception("Bad Token");
		}
		$this->validate(
			$this->dataStore->getAccessToken(
				$token->getKey()
			)
		);
	}
	
	/**
	 * Validate authorization parameters
	 *
	 * @param string $url the request url, e.g.: Util_OAuth_NameUtil::getRequestTokenUrl('https://portal.bancvue.com'); 
	 * @return void 
	 */
	private function validate(Util_OAuth_Token $token = null) {
		$foundSignature;
		$expectedSignature;
		$isValid = false;
		
		try {
			
			$foundSignature = $this->request->getSignature();
			
			if (!is_null($this->request->getToken())) {
				try {
					$expectedSignature = $this->request->generateSignature($token);
				} catch (Util_OAuth_BadTokenException $e) {
					throw new Util_OAuth_UnauthorizedException($e->getMessage());
				}
			} else {
				$expectedSignature = $this->request->generateSignature();
			}

			$isValid = $foundSignature == $expectedSignature;

		} catch (Util_OAuth_UnauthorizedException $e) {
			throw $e;
		} catch (Util_OAuth_Exception $e) {
			throw new Util_OAuth_BadRequestException($e->getMessage());
		}
		
		$this->isValid = $isValid;
		if (!$this->isValid()) {
			throw new Util_OAuth_UnauthorizedException(sprintf("Signatures don't match: \nExpected: %s\nFound: %s", $expectedSignature, $foundSignature));
		}
	}
	
	public function isValid() {
		return $this->isValid;
	}
	
}