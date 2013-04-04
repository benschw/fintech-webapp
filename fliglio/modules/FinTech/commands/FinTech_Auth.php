<?php

/**
 *
 * @package FinTech
 */
class FinTech_Auth implements Flfc_Routable {
	/**
	 * @var Flfc_Context
	 */
	private $context;

	public function __construct(Flfc_Context $context) {
		$this->context = $context;
		
	}

	/**
	 * @return Fltk_JsonView
	 */
	public function status() {
		// $facebook = new Facebook(array(
		// 	'appId'  => FB_APP_ID,
		// 	'secret' => FB_APP_SECRET,
		// ));
		// 
		// $user = $facebook->getUser();
		// if ($user) {
		//   $logoutUrl = $facebook->getLogoutUrl();
		// }

		$sess = Util_Storage_Session::singleton();

		return new Fltk_JsonView(array(
			"loggedIn"  => isset($sess->oauth_id),
			"firstName" => isset($sess->firstName) ? $sess->firstName : null,
			"lastName"  => isset($sess->lastName) ? $sess->lastName : null,
			"email"     => isset($sess->email) ? $sess->email : null,
			"userName"  => isset($sess->userName) ? $sess->userName : null,
		));
	}
	
	/**
	 * @return Fltk_JsonView
	 */
	public function login() {
		$sess = Util_Storage_Session::singleton();

		$facebook = new Facebook(array(
			'appId'  => FB_APP_ID,
			'secret' => FB_APP_SECRET,
		));

		$user = $facebook->getUser();
		if ($user) {
			try {

				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');

				$sess = Util_Storage_Session::singleton();
				$sess->oauth_id  = $user_profile['id'];
				$sess->firstName = $user_profile['first_name'];
				$sess->lastName  = $user_profile['last_name'];
				$sess->email     = $user_profile['email'];
				$sess->userName  = strtolower($sess->firstName . $sess->lastName); // DO THIS REAL?

				throw new Flfc_RedirectException("Logged in, redirecting", 302, "/#/".$sess->userName);

			} catch (FacebookApiException $e) {
			
				throw $e;
			}
		} else {
			# There's no active session, let's generate one
			$loginUrl = $facebook->getLoginUrl(array(
				'scope'        => 'email', 
				'redirect_uri' => Web_HttpAttributes::getProtocol().'://'.Web_HttpAttributes::getHttpHost().'/api/auth/login'
			));
			throw new Flfc_RedirectException("redirecting for login", 302, $loginUrl);
		}
	}
	
	public function logout() {
		$sess = Util_Storage_Session::singleton();
		
		unset($sess->oauth_id);
		unset($sess->firstName);
		unset($sess->lastName);
		unset($sess->email);
		session_destroy();

		throw new Flfc_RedirectException("Logged out", 302, "/#/");
	}
}
