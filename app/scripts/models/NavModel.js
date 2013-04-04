/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			activePage: null,
			loggedIn: false,
			firstName: '',
			lastName: '',
			email: '',
			userName: ''
		},
		url: '/api/auth/status',
		initialize: function () {
			this.set('activePage', null);
		},
		setActivePage: function (page) {
			this.set('activePage', page);
		}
	});

	Model.pages = {
		HOME: 'home_page',
		ABOUT: 'about_page',
		CONTACT: 'contact_page',
		DASHBOARD: 'dashboard_page'
	};

	return Model;
});