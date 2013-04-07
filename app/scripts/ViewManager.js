/*global define */
define(['jquery', 'underscore', 'backbone',
		'models/NavModel',
		'models/HomeModel',
		'models/UserNavModel',
		'models/MarketItemModel',
		'models/MarketItemsModel',
		'models/MarketTransactionModel',
		'models/MarketTransactionsModel',
		'views/NavView',
		'views/HomeView',
		'views/TplView',
		'views/UserNavView',
		'views/MarketItemView',
		'views/MarketItemsView'
	], function ($, _, Backbone,
		NavModel,
		HomeModel,
		UserNavModel,
		MarketItemModel,
		MarketItemsModel,
		MarketTransactionModel,
		MarketTransactionsModel,
		NavView,
		HomeView,
		TplView,
		UserNavView,
		MarketItemView,
		MarketItemsView
	) {
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

	ViewMgr.prototype.homeModel      = null;
	ViewMgr.prototype.homeView       = null;
	ViewMgr.prototype.aboutView      = null;
	ViewMgr.prototype.contactView    = null;
	ViewMgr.prototype.helpView       = null;

	ViewMgr.prototype.home = function () {
		this.homeModel = this.homeModel ? this.homeModel : new HomeModel({'title': 'no auth'});
		this.homeView = this.homeView ? this.homeView : new HomeView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': this.homeModel
		});
		this.homeView.render();

	};
	ViewMgr.prototype.about = function () {
		this.aboutView = this.aboutView ? this.aboutView : new TplView({
			'el': $(ViewMgr.regions.CONTENT),
			'tplPath': 'app/scripts/tpl/about.html'
		});
		this.aboutView.render();

	};
	ViewMgr.prototype.contact = function () {
		this.contactView = this.contactView ? this.contactView : new TplView({
			'el': $(ViewMgr.regions.CONTENT),
			'tplPath': 'app/scripts/tpl/contact.html'
		});
		this.contactView.render();
	};
	ViewMgr.prototype.help = function () {
		this.helpView = this.helpView ? this.helpView : new TplView({
			'el': $(ViewMgr.regions.CONTENT),
			'tplPath': 'app/scripts/tpl/help.html'
		});
		this.helpView.render();
	};

	/**
	 * Authorized Pages
	 */

	ViewMgr.prototype.dashboard = function (userName) {
		this.navModel.setActivePage(NavModel.pages.DASHBOARD);

		var model = new HomeModel({'title': userName + '\'s Dashboard'});
		var view  = new HomeView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': model
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.random = function () {
		this.navModel.setActivePage(NavModel.pages.RANDOM);

		var model = new MarketItemsModel();
		var view  = new MarketItemsView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': model,
			'title' : 'Random Markets'
		});

		model.fetch();
		view.render();

		return this;
	};
	ViewMgr.prototype.newMarkets = function () {
		this.navModel.setActivePage(NavModel.pages.NEW_MARKETS);

		var model = new MarketItemsModel();
		var view  = new MarketItemsView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': model,
			'title' : 'New Markets'
		});

		model.fetch({sort: 'new'});
		view.render();

		return this;
	};
	ViewMgr.prototype.topMarkets = function () {
		this.navModel.setActivePage(NavModel.pages.TOP_MARKETS);

		var model = new MarketItemsModel();
		var view  = new MarketItemsView({
			'el': $(ViewMgr.regions.CONTENT),
			'model': model,
			'title' : 'Top Markets'
		});

		model.fetch({sort: 'top'});
		view.render();

		return this;
	};

	// market item section

	ViewMgr.prototype.marketItem = function (marketId) {
		var txnModel = new MarketTransactionsModel([], {
			'url': '/api/market/' + marketId + '/transactions'
		});
		txnModel.fetch();

		var model = new MarketItemModel({id: marketId});
		new MarketItemView({
			'el'       : $(ViewMgr.regions.CONTENT),
			'model'    : model,
			'txnModel' : txnModel
		});
		model.fetch();

		return this;
	};

	/* Settings Section */
	ViewMgr.prototype.userNav = null;
	ViewMgr.prototype.userNavView = null;

	ViewMgr.prototype.userSettings = function (userName) {
		this.navModel.setActivePage(null);

		this.userNav = this.userNav ? this.userNav : new UserNavModel({
			'userName': userName
		});
		this.userNavView = this.userNavView ? this.userNavView : new UserNavView({
			'el': $(ViewMgr.regions.CONTENT),
			model: this.userNav
		});
		this.userNav.setActivePage(UserNavModel.pages.SETTINGS);
		this.userNavView.render();

		var view = new TplView({
			'el': $('#userContent'),
			'tplPath': 'app/scripts/tpl/settings.html'
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.userMarketsIn = function (userName) {
		this.navModel.setActivePage(null);

		this.userNav = this.userNav ? this.userNav : new UserNavModel({
			'userName': userName
		});
		this.userNavView = this.userNavView ? this.userNavView : new UserNavView({
			'el': $(ViewMgr.regions.CONTENT),
			model: this.userNav
		});
		this.userNav.setActivePage(UserNavModel.pages.MARKETS_IN);
		this.userNavView.render();

		var view = new TplView({
			'el': $('#userContent'),
			'tplPath': 'app/scripts/tpl/settings.html'
		});
		view.render();
		return this;
	};
	ViewMgr.prototype.userMarketsRun = function (userName) {
		this.navModel.setActivePage(null);

		this.userNav = this.userNav ? this.userNav : new UserNavModel({
			'userName': userName
		});
		this.userNavView = this.userNavView ? this.userNavView : new UserNavView({
			'el': $(ViewMgr.regions.CONTENT),
			model: this.userNav
		});
		this.userNav.setActivePage(UserNavModel.pages.MARKETS_RUN);
		this.userNavView.render();


		var view = new TplView({
			'el': $('#userContent'),
			'tplPath': 'app/scripts/tpl/settings.html'
		});
		view.render();
		return this;
	};


	return ViewMgr;
});