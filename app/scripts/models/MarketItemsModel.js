/*global define */
define(['underscore', 'backbone', 'models/MarketItemModel'], function (_, Backbone, MarketItemModel) {
	'use strict';

	var Model = Backbone.Collection.extend({
		title : 'Market Items',
		model : MarketItemModel,
		url : '/api/marketItems',
		defaults: {
			title : 'Market Items'
		}
	});

	// var Model = Backbone.Model.extend({
	// 	defaults: {
	// 		title : 'Market Items',
	// 		items : [{
	// 			id               : 1123,
	// 			orgName          : 'Austin Pets Alive',
	// 			marketName       : '$25 Gift Cards to Local Restraunts',
	// 			discription      : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
	// 			orgImage         : '/images/logos/austindog.png',
	// 			seoName          : 'austin-pets-alive-gift-cards'
	// 		}, {
	// 			id               : 23984,
	// 			orgName          : 'Red Cross',
	// 			marketName       : '$30 Gift Cards to Home Depot',
	// 			discription      : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
	// 			orgImage         : '/images/logos/redcross.png',
	// 			seoName          : 'red-cross-home-depot'
	// 		}]
	// 	}
	// });

	return Model;
});