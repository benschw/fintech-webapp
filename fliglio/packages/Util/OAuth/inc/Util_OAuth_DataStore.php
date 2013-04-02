<?php

/**
 * Data Access layer to store Tokens and Consumer Authentication
 *
 * @package FlAuthLib
 */
abstract class Util_OAuth_DataStore {
	
	/**
	 * Register nonce 
	 * Nonce / Timestamp pair can only be used once per consumer
	 *
	 * @param string $nonce 
	 * @param string $timestamp 
	 * @return void
	 * @throws Util_OAuth_DuplicateNonceException
	 */
	abstract public function registerNonce($nonce, $timestamp);
		
	/**
	 * Store token for later (cross request) retrieval
	 *
	 * @param  Util_OAuth_Token $token
	 * @return void
	 */
	abstract public function registerRequestToken(Util_OAuth_Token $token);
	
	/**
	 * Use Request Token key to get Request Token object (with secret)
	 *
	 * @param string $key token key
	 * @return Util_OAuth_Token
	 * @throws Util_OAuth_BadTokenException if request token isn't found
	 */
	abstract public function getRequestToken($key);

	/**
	 * Get registered Access Token
	 *
	 * @param string $key Access Token Key
	 * @return Util_OAuth_Token
	 * @throws Util_OAuth_BadTokenException if access token isn't found
	 */
	abstract public function getAccessToken($key);
	
	/**
	 * If user is logged in, authorize token
	 *
	 * @param Util_OAuth_Token $token 
	 * @return void
	 * @throws Util_OAuth_BadTokenException if request token isn't found
	 */
	abstract public function authorizeToken(Util_OAuth_Token $requestToken);
	
	/**
	 * Exchanged authorized Request Token for Access Token
	 * - registers access token
	 *
	 * @param Util_OAuth_Token $requestToken Request Token Key
	 * @return Util_OAuth_Token
	 * @throws Util_OAuth_BadTokenException if request token isn't found
	 * @throws Util_OAuth_UnauthorizedException if request token isn't authorized
	 */
	abstract public function exchangeRequestToken(Util_OAuth_Token $requestToken);
	
	abstract public function deleteAccessToken(Util_OAuth_Token $accessToken);
	
	/**
	 * Register a callback address keyed by it's corresponding Request Token
	 *
	 * @param Util_OAuth_Token $requestToken 
	 * @param string $callback 
	 * @return void
	 */
	abstract public function registerCallback(Util_OAuth_Token $requestToken, $callback);
	
	/**
	 * Look up a callback url with a request token
	 *
	 * @param Util_OAuth_Token $requestToken 
	 * @return string
	 */
	abstract public function getCallback(Util_OAuth_Token $requestToken);
}