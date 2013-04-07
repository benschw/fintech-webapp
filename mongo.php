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


	$db->Market->insert(array(
				'id' => 1,
				'orgName'        => 'Austin Pets Alive',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/austindog.png',
            	'seoName'        => 'austin-pets-alive-gift-cards'
	));
	$db->Market->insert(array(
				'id' => 2,
				'orgName'        => 'March of Dimes',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/marchofdimes.png',
            	'seoName'        => 'march-of-dimes'
	));
	$db->Market->insert(array(
				'id' => 3,
				'orgName'        => 'Michael J Fox',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/michaeljfox.png',
            	'seoName'        => 'michael-j-fox'
	));
	$db->Market->insert(array(
				'id' => 4,
				'orgName'        => 'Red Cross',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/redcross.png',
            	'seoName'        => 'red-cross'
	));
	$db->Market->insert(array(
				'id' => 5,
				'orgName'        => 'Stand Up to Cancer',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/standuptocancer.png',
            	'seoName'        => 'stand-up-to-cancer'
	));
	$db->Market->insert(array(
				'id' => 6,
				'orgName'        => 'American Humane',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'discription'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
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
