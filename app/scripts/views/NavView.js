/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl', 'bootstrap'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			_.bindAll(this, 'render');

		    this.model.on('change', this.render);
		    
			
		},
		render: function () {
			var compiledTemplate = tpl['app/scripts/tpl/nav.html'](this.model.toJSON());
			
			this.$el.empty();
			this.$el.append(compiledTemplate).show();

			$('.dropdown-toggle').dropdown();

			return this;
		}
	});
	
	return View;
});