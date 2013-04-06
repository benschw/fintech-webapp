/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, templates) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			
		},
		render: function () {
			$('body').removeClass();

			var data = {};

			var compiledTemplate = templates[this.options.tplPath](data);
			
			this.$el.empty();
			this.$el.append(compiledTemplate).show();
			return this;
		}
	});
	
	return View;
});