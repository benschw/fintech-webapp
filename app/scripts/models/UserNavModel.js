/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			userName: '',
			activePage: null,
		},
		setActivePage: function (page) {
			this.set('activePage', page);
		}
	});

	Model.pages = {
		SETTINGS: 'settings_page',
		MARKETS_RUN: 'markets_run_page',
		MARKETS_IN: 'markets_in_page'
	};

	return Model;
});