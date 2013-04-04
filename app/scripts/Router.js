/*global define */
define(['jquery', 'underscore', 'backbone', 'ViewManager'], 
		function ($, _, Backbone, ViewManager) {
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
		var viewMgr = new ViewManager();

		var router = new AppRouter();
		
		router.on('route:home', function () {
			viewMgr.home();
		});
		router.on('route:about', function () {
			viewMgr.about();
		});
		router.on('route:contact', function () {
			viewMgr.contact();
		});

		router.on('route:dashboard', function (un) {
			viewMgr.dashboard(un);
		});
		router.on('route:userSettings', function (un) {
			viewMgr.userSettings(un);
		});


		router.on('route:defaultAction', function (actions) {
			console.log('No route:', actions);
		});
		
		Backbone.history.start({pushState: true});
		
		
		
		$(document).delegate('a', 'click', function (evt) {
			// Get the anchor href and protcol
			var href = $(this).attr('href');
			var protocol = this.protocol + '//';

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