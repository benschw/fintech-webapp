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

			$('a#purchase').click(function () {
				popup.show();

				$('#close').click(function () {
					popup.hide();
				});

				$('.fndr-form .btn').click(function () {
					var pin = $('input#pin').val();
					var id  = model.id;

					// var that = this;
					$.getJSON('/api/payments/send', {'pin' : pin, 'id'  : id}).done(function () {
						popup.hide();
					});
				});

			});

			return this;
		}
	});
	
	return View;
});