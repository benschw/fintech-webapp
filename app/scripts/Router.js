/*global define */
define(['jquery', 'underscore', 'backbone', 
		'commands/Home',
		'commands/About',
		'commands/Contact',
		'commands/UserDashboard',
		'commands/UserSettings'
	], function ($, _, Backbone, Home, About, Contact, UserDashboard, UserSettings) {
	'use strict';

	var AppRouter = Backbone.Router.extend({
		routes: {
			'' : 'home',
			'about': 'about',
			'contact': 'contact',
			':userName/settings': 'userSettings',
			':userName': 'dashboard',
			'*actions': 'defaultAction'
		}
	});
	
	var initialize = function () {

		var router = new AppRouter();
		
		router.on('route:home', function () {
			Home.initialize();
		});
		router.on('route:about', function () {
			About.initialize();
		});
		router.on('route:contact', function () {
			Contact.initialize();
		});

		router.on('route:dashboard', function (un) {
			var v = new UserDashboard({userName: un});
			v.render();
		});
		router.on('route:userSettings', function (un) {
			var v = new UserSettings({userName: un});
			v.render();
		});


		router.on('route:defaultAction', function (actions) {
			console.log('No route:', actions);
		});
		
		Backbone.history.start({pushState: true});
		
		
		
		$(document).delegate("a", "click", function(evt) {
			// Get the anchor href and protcol
			var href = $(this).attr("href");
			var protocol = this.protocol + "//";

			// Ensure the protocol is not part of URL, meaning its relative.
			// Stop the event bubbling to ensure the link will not cause a page refresh.
			if (href.slice(protocol.length) !== protocol) {
				if (href.substr(0, 5) !== '/api/') {
					evt.preventDefault();

					// Note by using Backbone.history.navigate, router events will not be
					// triggered.  If this is a problem, change this to navigate on your
					// router.
					router.navigate(href, true);
				}
			}
		});
	};
	
	
	return {initialize: initialize};
});