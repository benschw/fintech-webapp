/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			_.bindAll(this, 'render');

		    this.model.on("change", this.render);
		    
			$('.dropdown-toggle').dropdown()
			
		},
		render: function () {
			var compiledTemplate = tpl['app/scripts/tpl/nav.html'](this.model.toJSON());
			
			this.$el.empty();
			this.$el.append(compiledTemplate).show();

			return this;
		}
	});
	
	return View;
});