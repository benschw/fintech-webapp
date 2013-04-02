/*global define */
define(['jquery', 'underscore', 'backbone', 
		'models/NavModel', 
		'views/NavView', 
		'models/HomeModel', 
		'views/HomeView'
	], function ($, _, Backbone, NavModel, NavView, HomeModel, HomeView) {
	'use strict';

	var initialize = function () {
		var navm = new NavModel({homeActive: true});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});

		var model = new HomeModel({'title': 'galaxy'});
		var view  = new HomeView({
			'el': $('#content'),
			'model': model
		});
		view.render();

	};

	return {initialize: initialize};
});