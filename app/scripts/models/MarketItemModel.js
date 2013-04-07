/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			id               : 1123,
			orgName          : 'Default',
			marketName       : 'Default',
			description      : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
			orgImage         : '/images/logos/austindog.png',
			numAvailable     : 0,
			currentPrice     : 0,
			seoName          : 'austin-pets-alive-gift-cards'
		},
        url: function () {
            return '/api/market/' + this.id;
        }

	});

	return Model;
});