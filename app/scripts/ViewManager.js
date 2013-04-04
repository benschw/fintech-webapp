/*global define */
define(['jquery', 'underscore', 'backbone',
		'models/NavModel',
		'views/NavView',
		'models/HomeModel',
		'views/HomeView',
		'views/TplView',
		'models/UserNavModel',
		'views/UserNavView'
	], function ($, _, Backbone, NavModel, NavView, HomeModel, HomeView, TplView, UserNavModel, UserNavView) {
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

	/* Settings Section */

	ViewMgr.prototype.userSettings = function (userName) {
		this.navModel.setActivePage(null);

		var nav = new UserNavModel({
			'userName': userName,
			activePage: UserNavModel.pages.SETTINGS
		});

		var navView = new UserNavView({
			'el': $(ViewMgr.regions.CONTENT),
			model: nav
		});
		navView.render();

		var view = new TplView({
			'el': $('#userContent'),
			'tplPath': 'app/scripts/tpl/settings.html'
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.userMarketsIn = function (userName) {
		this.navModel.setActivePage(null);

		var nav = new UserNavModel({
			'userName': userName,
			activePage: UserNavModel.pages.SETTINGS
		});

		var navView = new UserNavView({
			'el': $(ViewMgr.regions.MARKETS_IN),
			model: nav
		});
		navView.render();

		var view = new TplView({
			'el': $('#userContent'),
			'tplPath': 'app/scripts/tpl/settings.html'
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.userMarketsRun = function (userName) {
		this.navModel.setActivePage(null);

		var nav = new UserNavModel({
			'userName': userName,
			activePage: UserNavModel.pages.MARKETS_RUN
		});

		var navView = new UserNavView({
			'el': $(ViewMgr.regions.CONTENT),
			model: nav
		});
		navView.render();

		var view = new TplView({
			'el': $('#userContent'),
			'tplPath': 'app/scripts/tpl/settings.html'
		});
		view.render();
		return this;
	};


	return ViewMgr;
});