/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			title : 'Market Items',
			items : [{
				id               : 1123,
				title            : 'Austin Pets Alive',
				discription      : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
				profileImagePath : '',
				seoName          : 'austin-pets-alive'
			}, {
				id               : 23984,
				title            : 'Red Cross',
				discription      : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
				profileImagePath : '',
				seoName          : 'red-cross'
			}]
		}
	});

	return Model;
});