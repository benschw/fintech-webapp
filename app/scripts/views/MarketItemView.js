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

			var popup   = $('#popup');
			var loading = $('#loading');
			var close   = $('#close');

			popup.hide();
			loading.hide();

			// var that = this;
			$('a#purchase').click(function () {
				$('.fndr-form.pin').hide();
				close.hide();
				loading.show();

				popup.show();

				// close.click(function () {
				// 	popup.hide();
				// });

				// $('.fndr-form .btn').click(function () {
				// 	var pin = $('input#pin').val();
				// 	var id  = model.id;

				// 	$('.fndr-form.pin').hide();
				// 	close.hide();
				// 	loading.show();

				// 	$.getJSON('/api/payment/send', {'pin' : pin, 'id'  : id}).done(function () {
				// 		that.model.fetch();
				// 		popup.hide();
				// 	});
				// });

			});
			this.options.txnView.render();
			return this;
		}
	});
	
	return View;
});