<?php

/**
 * @group int
 */
class MongoTest extends PHPUnit_Framework_TestCase {
	
	public function testMongo() {

		try {
		  	// open connection to MongoDB server
			$c = new Mongo('54.244.120.37');

		  	// access database
			$db = $c->selectDB('fintech');

//
			// disconnect from server
		  	$c->close();
		} catch (MongoConnectionException $e) {
  			die('Error connecting to MongoDB server');
		} catch (MongoException $e) {
  			die('Error: ' . $e->getMessage());
		}

	}


}