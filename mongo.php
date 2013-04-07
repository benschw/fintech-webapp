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
	$db->User->insert(array("id" => 5, "firstName" => "Dwolla", "lastName" => "Reflector",'fbId' => 100004365394658, 'dwollaId' => '812-713-9234' ));


	$db->Market->insert(array(
				'id' => 1,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.06,
				'numAvailable'   => 24,
				'orgName'        => 'Austin Dog Rescue',
           		'marketName'     => '$10 Custom Dog Collars',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br /><br/>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/austindog.png',
            	'seoName'        => 'austin-dog-rescue-gift-cards'
	));
	$db->Market->insert(array(
				'id' => 2,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'numAvailable'   => 80,
				'orgName'        => 'March of Dimes',
           		'marketName'     => '$100 Amazon Gift Card',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/marchofdimes.png',
            	'seoName'        => 'march-of-dimes-amazon-gift-car'
	));
	$db->Market->insert(array(
				'id' => 3,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'numAvailable'   => 5,
				'orgName'        => 'Michael J Fox Foundation',
           		'marketName'     => '20 Pairs of Running Shoes (Nikes)',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br /><br/>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/michaeljfox.png',
            	'seoName'        => 'michael-j-fox-foundation-nikes'
	));
	$db->Market->insert(array(
				'id' => 4,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'numAvailable'   => 10,
				'orgName'        => 'Red Cross',
           		'marketName'     => '$75 Gift Cards to Home Depot',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/redcross.png',
            	'seoName'        => 'red-cross'
	));
	$db->Market->insert(array(
				'id' => 5,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'numAvailable'   => 30,
				'orgName'        => 'Stand Up to Cancer',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br /><br/>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/standuptocancer.png',
            	'seoName'        => 'stand-up-to-cancer'
	));
	$db->Market->insert(array(
				'id' => 6,
				'userId' 		 => 5,
				'startPrice'	 => 0.01,
				'currentPrice'	 => 0.02,
				'numAvailable'   => 50,
				'orgName'        => 'American Humane',
           		'marketName'     => '$25 Gift Cards to Local Resturants',
            	'description'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            	'orgImage'       => '/images/logos/americanhumane.png',
            	'seoName'        => 'american-humane'
    ));

    $db->Transaction->insert(array("fbId" => 100401316, "marketId" => 1, "userId" => 3, "time" => time()-60*4, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 734736716, "marketId" => 1, "userId" => 4, "time" => time()-60*8, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 1483899097, "marketId" => 2, "userId" => 1, "time" => time()-60*2, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 100000037326092, "marketId" => 2, "userId" => 2, "time" => time()-60*5, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 100401316, "marketId" => 2, "userId" => 3, "time" => time()-60*6, 'message' => " purchased an item" ));	
    $db->Transaction->insert(array("fbId" => 1483899097, "marketId" => 2, "userId" => 1, "time" => time()-60*3, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 100000037326092, "marketId" => 2, "userId" => 2, "time" => time()-60*2, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 734736716, "marketId" => 3, "userId" => 4, "time" => time()-60*1, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 1483899097, "marketId" => 3, "userId" => 1, "time" => time()-60*5, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 734736716, "marketId" => 3, "userId" => 4, "time" => time()-60*9, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 100000037326092, "marketId" => 4, "userId" => 2, "time" => time()-60*2, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 100000037326092, "marketId" => 4, "userId" => 2, "time" => time()-60*7, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 1483899097, "marketId" => 4, "userId" => 1, "time" => time()-60*2, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 1483899097, "marketId" => 5, "userId" => 1, "time" => time()-60*3, 'message' => " purchased an item" ));
    $db->Transaction->insert(array("fbId" => 100401316, "marketId" => 5, "userId" => 3, "time" => time()-60*8, 'message' => " purchased an item" ));
    

	// disconnect from server
  	$c->close();
} catch (MongoConnectionException $e) {
	die('Error connecting to MongoDB server');
} catch (MongoException $e) {
	die('Error: ' . $e->getMessage());
}
