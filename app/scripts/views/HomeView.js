/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			
		},
		
		events: {
			'click #test': 'testFcn'
		},
		
		testFcn: function (e) {
			e.preventDefault();
		},
		
		render: function () {
			$('body').removeClass();

			var compiledTemplate = tpl['app/scripts/tpl/home.html'](this.model.toJSON());

			this.$el.empty();
			this.$el.append(compiledTemplate).show();
			return this;
		}
	});
	
	return View;
});