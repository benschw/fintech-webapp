/*global define */
define(['jquery', 'underscore', 'backbone', 
		'models/NavModel', 
		'views/NavView', 
		'views/TplView'
	], function ($, _, Backbone, NavModel, NavView, TplView) {
	'use strict';

	var initialize = function () {
		var navm = new NavModel({aboutActive: true});
		navm.fetch();
		var navv = new NavView({
			'el': $('#nav'),
			'model': navm
		});

		var view = new TplView({
			'el': $('#content'),
			'tplPath': 'app/scripts/tpl/about.html'
		});
		view.render();
		
	};

	return {initialize: initialize};
});