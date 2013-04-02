/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			homeActive: false,
			aboutActive: false,
			contactActive: false,
			loggedIn: false,
			firstName: "",
			lastName: "",
			email: "",
			userName: ""
		},
		url: '/api/auth/status'
	});

	return Model;
});