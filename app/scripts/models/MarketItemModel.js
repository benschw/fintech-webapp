/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		url : '/api/market',
		defaults: {
			id               : 1123,
			orgName          : 'Austin Pets Alive',
			marketName       : '$25 Gift Cards to Local Restraunts',
			discription      : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
			orgImage         : '/images/logos/austindog.png',
			seoName          : 'austin-pets-alive-gift-cards'
		}
	});

	return Model;
});