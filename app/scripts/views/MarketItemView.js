/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl'], function ($, _, Backbone, tpl) {
	'use strict';
	
	var View = Backbone.View.extend({
		initialize: function () {
			_.bindAll(this, 'render');
			this.model.on('change', this.render);
		},
		render: function () {
			$('body').removeClass();
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
			console.log(model);
			return this;
		}
	});
	
	return View;
});