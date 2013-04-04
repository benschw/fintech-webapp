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
		this.navModel = new NavModel();
		this.navModel.fetch();

		this.navView = new NavView({
			'el': $(ViewMgr.regions.NAV),
			'model': this.navModel
		});
		this.navView.render();

	};
	
	ViewMgr.regions = {
		NAV: '#nav',
		CONTENT: '#content'
	};

	ViewMgr.prototype.home = function () {
		this.navModel.setActivePage(NavModel.pages.HOME);

		if (this.navModel.get('loggedIn')) {

			this.homeModelAuth = this.homeModelAuth ? this.homeModelAuth : new HomeModel({'title': 'auth'});
			this.homeViewAuth = this.homeViewAuth ? this.homeViewAuth : new HomeView({
				'el': $(ViewMgr.regions.CONTENT),
				'model': this.homeModelAuth
			});
			this.homeViewAuth.render();

		} else {
			
			this.homeModelNoAuth = this.homeModelNoAuth ? this.homeModelNoAuth : new HomeModel({'title': 'no auth'});
			this.homeViewNoAuth = this.homeViewNoAuth ? this.homeViewNoAuth : new HomeView({
				'el': $(ViewMgr.regions.CONTENT),
				'model': this.homeModelNoAuth
			});
			this.homeViewNoAuth.render();
		}

	};
	ViewMgr.prototype.about = function () {
		this.navModel.setActivePage(NavModel.pages.ABOUT);

		console.log(this.navModel.toJSON());
		
		var view = new TplView({
			'el': $(ViewMgr.regions.CONTENT),
			'tplPath': 'app/scripts/tpl/about.html'
		});
		view.render();

	};
	ViewMgr.prototype.contact = function () {
		this.navModel.setActivePage(NavModel.pages.CONTACT);

		
		var view = new TplView({
			'el': $(ViewMgr.regions.CONTENT),
			'tplPath': 'app/scripts/tpl/contact.html'
		});
		view.render();

	};
	ViewMgr.prototype.dashboard = function (userName) {
		this.navModel.setActivePage(NavModel.pages.DASHBOARD);


		var model = new HomeModel({'title': 'Dashboard for ' + userName});
		var view  = new HomeView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': model
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.userSettings = function (userName) {
		this.navModel.setActivePage(null);


		var model = new HomeModel({'title': 'Settings for ' + userName});
		var view  = new HomeView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': model
		});
		view.render();
		return this;
	};


	return ViewMgr;
});