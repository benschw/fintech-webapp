<?php

class Util_OAuth_NameUtil {

	public static function getRequestTokenUrl($server) {
		return $server . '/services/auth-service/getRequestToken';
	}
	public static function getAuthorizationUrl($server, Util_OAuth_Token $token) {
 		return sprintf(
			"%s/accounts/service-login?oauth_token=%s",
			$server,
			Util_OAuth_Util::urlencode_rfc3986($token->getKey())
		);
	}
	public static function getAccessTokenUrl($server) {
		return $server . '/services/auth-service/getAccessToken';
	}

}