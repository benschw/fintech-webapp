/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			_.bindAll(this, 'render');
			this.model.on('add', this.render);
		},
		render: function () {
			$('body').addClass('big-bg');

			var model = this.model.toJSON();
			var compiledTemplate = tpl['app/scripts/tpl/marketItem.html'](model);

			this.$el.empty();
			this.$el.append(compiledTemplate).show();

			var popup = $('#popup');
			popup.hide();

			// $('a#purchase').click(function () {
				// console.log('Ello world');
				// popup.show();
			// });

			return this;
		}
	});
	
	return View;
});