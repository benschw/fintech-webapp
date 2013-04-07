/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			_.bindAll(this, 'render');
			this.model.on('add', this.render);
		},
		render: function () {
			$('body').removeClass();

			var compiledTemplate = tpl['app/scripts/tpl/marketItemsList.html']({
				title : this.options.title,
				items : this.model.toJSON()
			});

			this.$el.empty();
			this.$el.append(compiledTemplate).show();

			return this;
		}
	});
	
	return View;
});