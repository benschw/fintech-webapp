<?php
/**
 * @todo this only works fully for post requests
 * 
 * @package Web
 */
class Web_Curl {

	const METHOD_POST = 'post';
	const METHOD_GET  = 'get';

	/**
	 * Make a request using the supplied Web_CurlRequest object. 
	 * Set the response on the supplied Web_CurlResponse object.
	 *
	 * @param Web_CurlRequest $request
	 * @param Web_CurlResponse $response
	 * @return void
	 */
	public static function makeRequest(Web_CurlRequest $request, Web_CurlResponse $response) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request->getUrl()); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request->getHeaders());
		
		// error_log("curl: " . $request->getUrl());
		$h = $request->getHeaders();
		// error_log("curlheaders: " . $h[0]);
		
		$postFields = is_array($request->getParams()) ? http_build_query($request->getParams()) : $request->getParams();
		
		if ($request->getMethod() == self::METHOD_POST) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		foreach ($request->getOptions() as $option => $value) {
			curl_setopt($ch, $option, $value);
		}

		$response->setContent(curl_exec($ch));

		if (curl_errno($ch) != 0) {
			$response->setErrorNumber(curl_errno($ch));
			$response->setErrorMessage(curl_error($ch));
		}
		
		$info = curl_getinfo($ch);
		$response->setHttpCode($info['http_code']);
		
		$effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		$response->setEffectiveUrl($effectiveUrl);

		curl_close($ch);
	}


}