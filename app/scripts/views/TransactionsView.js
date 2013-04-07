/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			_.bindAll(this, 'render');
			this.model.on('add', this.render);
		},
		render: function () {
			var compiledTemplate = tpl['app/scripts/tpl/txnList.html']({
				items : _.shuffle(this.model.toJSON())
			});

			this.$el.empty();
			this.$el.append(compiledTemplate).show();

			return this;
		}
	});
	
	return View;
});