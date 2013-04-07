<?php


try {
  	// open connection to MongoDB server
	$c = new Mongo('localhost');

  	// access database
	$db = $c->selectDB('fintech');
	$db->drop();


	$db->User->insert(array("id" => 1, "firstName" => "Susi",   "lastName" => "Rathmann", 'fbId' => 1483899097 ));
	$db->User->insert(array("id" => 2, "firstName" => "Ben",    "lastName" => "Schwartz", 'fbId' => 100000037326092 ));
	$db->User->insert(array("id" => 3, "firstName" => "Philip", "lastName" => "Whitt",    'fbId' => 100401316 ));
	$db->User->insert(array("id" => 4, "firstName" => "Ben",    "lastName" => "Morrison", 'fbId' => 734736716 ));
	$db->User->insert(array("id" => 5, "firstName" => "Dwolla", "lastName" => "Reflector",'fbId' => 100004365394658 ));


	$db->Market->insert(array(
				'id' => 1,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'orgName'        => 'Austin Dog Rescue',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/austindog.png',
            	'seoName'        => 'austin-dog-rescue-gift-cards'
	));
	$db->Market->insert(array(
				'id' => 2,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'orgName'        => 'March of Dimes',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/marchofdimes.png',
            	'seoName'        => 'march-of-dimes'
	));
	$db->Market->insert(array(
				'id' => 3,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'orgName'        => 'Michael J Fox',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/michaeljfox.png',
            	'seoName'        => 'michael-j-fox'
	));
	$db->Market->insert(array(
				'id' => 4,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'orgName'        => 'Red Cross',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/redcross.png',
            	'seoName'        => 'red-cross'
	));
	$db->Market->insert(array(
				'id' => 5,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'orgName'        => 'Stand Up to Cancer',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/standuptocancer.png',
            	'seoName'        => 'stand-up-to-cancer'
	));
	$db->Market->insert(array(
				'id' => 6,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'orgName'        => 'American Humane',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/americanhumane.png',
            	'seoName'        => 'american-humane'
    ));

	// disconnect from server
  	$c->close();
} catch (MongoConnectionException $e) {
	die('Error connecting to MongoDB server');
} catch (MongoException $e) {
	die('Error: ' . $e->getMessage());
}
