<?php

class Util_OAuth_Util {

	public static function generateTimestamp() {
		return time();
	}

	public static function generateNonce() {
		return md5(microtime() . mt_rand());
	}

	public static function urlencode_rfc3986($input) {
		if (is_array($input)) {
			return array_map(array('Util_OAuth_Util', 'urlencode_rfc3986'), $input);
		} else if (is_scalar($input)) {
			return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
		} else {
			return '';
		}
	}


	// This decode function isn't taking into consideration the above
	// modifications to the encoding process. However, this method doesn't
	// seem to be used anywhere so leaving it as is.
	public static function urldecode_rfc3986($string) {
		return urldecode($string);
	}

	public static function splitHeader($header, $onlyAllowOAuthParameters = true) {
		$params = array();
		if (preg_match_all('/('.($onlyAllowOAuthParameters ? 'oauth_' : '').'[a-z_-]*)=(:?"([^"]*)"|([^,]*))/', $header, $matches)) {
			foreach ($matches[1] as $i => $h) {
				$params[$h] = $this->urldecode_rfc3986(empty($matches[3][$i]) ? $matches[4][$i] : $matches[3][$i]);
			}
			if (isset($params['realm'])) {
				unset($params['realm']);
			}
		}
		return $params;
	}

	public static function buildAuthHeader($params) {
		$arr = array();
		foreach ($params as $key => $value) {
			$arr[] = sprintf('%s="%s"', self::urlencode_rfc3986($key), self::urlencode_rfc3986($value));
		}

		return "OAuth " . implode(',', $arr);
	}
	public static function getConsumerKeyFromAuthHeader($input) {
		$authParams = self::parseAuthHeader($input);
		return $authParams['oauth_consumer_key'];
	}
	public static function parseAuthHeader($input) {
		if (substr($input, 0, 6) != "OAuth ") {
			throw new Util_OAuth_BadRequestException("Authorization header is malformed");
		}
		$paramString = substr($input, 6);
		
		$pairs = explode(",", $paramString);
		
		return self::parseParameterPairs($pairs);
	}

	// This function takes a input like a=b&a=c&d=e and returns the parsed
	// parameters like this
	// array('a' => array('b','c'), 'd' => 'e')
	public static function parseParameters( $input ) {
		if (!isset($input) || !$input) return array();

		$pairs = explode('&', $input);

		return self::parseParameterPairs($pairs);

	}
	private static function parseParameterPairs($pairs) {
		$parsed_parameters = array();
		foreach ($pairs as $pair) {
			$split = explode('=', $pair, 2);
			$parameter = self::urldecode_rfc3986($split[0]);
			$value = isset($split[1]) ? self::urldecode_rfc3986($split[1]) : '';
			$value = trim($value, '"');
			if (isset($parsed_parameters[$parameter])) {
				// We have already recieved parameter(s) with this name, so add to the list
				// of parameters with this name

				if (is_scalar($parsed_parameters[$parameter])) {
					// This is the first duplicate, so transform scalar (string) into an array
					// so we can add the duplicates
					$parsed_parameters[$parameter] = array($parsed_parameters[$parameter]);
				}

				$parsed_parameters[$parameter][] = $value;
			} else {
				$parsed_parameters[$parameter] = $value;
			}
		}
		return $parsed_parameters;
	
	}

	public static function buildHttpQuery($params) {
		if (!$params) return '';

		// Urlencode both keys and values
		$keys = self::urlencode_rfc3986(array_keys($params));
		$values = self::urlencode_rfc3986(array_values($params));
		$params = array_combine($keys, $values);

		// Parameters are sorted by name, using lexicographical byte value ordering.
		// Ref: Spec: 9.1.1 (1)
		uksort($params, 'strcmp');

		$pairs = array();
		foreach ($params as $parameter => $value) {
			if (is_array($value)) {
				// If two or more parameters share the same name, they are sorted by their value
				// Ref: Spec: 9.1.1 (1)
				// June 12th, 2010 - changed to sort because of issue 164 by hidetaka
				sort($value, SORT_STRING);
				foreach ($value as $duplicate_value) {
					$pairs[] = $parameter . '=' . $duplicate_value;
				}
			} else {
				$pairs[] = $parameter . '=' . $value;
			}
		}
		// For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61)
		// Each name-value pair is separated by an '&' character (ASCII code 38)
		return implode('&', $pairs);
	}

}