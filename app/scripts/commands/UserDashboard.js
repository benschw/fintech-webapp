/*global define */
define(['jquery', 'underscore', 'backbone', 
		'models/NavModel', 
		'views/NavView', 
		'models/HomeModel', 
		'views/HomeView'
	], function ($, _, Backbone, NavModel, NavView, HomeModel, HomeView) {
	'use strict';

	var View = Backbone.View.extend({

		render: function() {
			var navm = new NavModel({});
			navm.fetch();
			var navv = new NavView({
				'el': $('#nav'),
				'model': navm
			});
			var model = new HomeModel({'title': 'Dashboard for '+this.options.userName});
			var view  = new HomeView({
				'el': $('#content'),
				'model': model
			});
			view.render();
			return this;
		}

	});


	return View;
});