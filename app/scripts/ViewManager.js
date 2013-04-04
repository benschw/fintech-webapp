/*global define */
define(['jquery', 'underscore', 'backbone',
		'models/NavModel',
		'views/NavView',
		'models/HomeModel',
		'views/HomeView',
		'views/TplView'
	], function ($, _, Backbone, NavModel, NavView, HomeModel, HomeView, TplView) {
	'use strict';

	/**
	 * @constructor
	 */
	var ViewMgr = function () {
	};

	ViewMgr.prototype.home = function () {
		var navm = new NavModel({homeActive: true});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});
		navv.render();

		var model = new HomeModel({'title': 'galaxy'});
		var view  = new HomeView({
			'el': $('#content'),
			'model': model
		});
		view.render();

	};
	ViewMgr.prototype.about = function () {
		var navm = new NavModel({aboutActive: true});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});
		navv.render();
		
		var view = new TplView({
			'el': $('#content'),
			'tplPath': 'app/scripts/tpl/about.html'
		});
		view.render();

	};
	ViewMgr.prototype.contact = function () {
		var navm = new NavModel({contactActive: true});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});
		navv.render();
		
		var view = new TplView({
			'el': $('#content'),
			'tplPath': 'app/scripts/tpl/contact.html'
		});
		view.render();

	};
	ViewMgr.prototype.dashboard = function (userName) {
		var navm = new NavModel({dashboardActive: true});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});
		navv.render();

		var model = new HomeModel({'title': 'Dashboard for ' + userName});
		var view  = new HomeView({
			'el': $('#content'),
			'model': model
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.userSettings = function (userName) {
		var navm = new NavModel({});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});
		navv.render();

		var model = new HomeModel({'title': 'Settings for ' + userName});
		var view  = new HomeView({
			'el': $('#content'),
			'model': model
		});
		view.render();
		return this;
	};


	return ViewMgr;
});