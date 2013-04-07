/*global define */
define(['jquery', 'underscore', 'backbone', 'tpl', 'views/TransactionsView'], function ($, _, Backbone, tpl, TransactionsView) {
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

			this.txnView = new TransactionsView({
				'el'    : $('#fndr-transactions'),
				'model' : this.options.txnModel
			});
			this.txnView.render();

			var popup   = $('#popup');
			var loading = $('#loading');
			var close   = $('#close');

			popup.hide();
			loading.hide();

			var that = this;
			$('a#purchase').click(function () {
				popup.show();

				close.click(function () {
					popup.hide();
				});

				$('.fndr-form .btn').click(function () {
					var pin = $('input#pin').val();
					var id  = model.id;

					$('.fndr-form.pin').hide();
					close.hide();
					loading.show();

					$.getJSON('/api/payment/send', {'pin' : pin, 'id'  : id}).done(function () {
						loading.empty();
						loading.append($('<h2>Purchase Complete</h2>'));

						setTimeout(function () {
							popup.hide();
							that.model.fetch();
							that.options.txnModel.fetch();
						}, 2000);
					});
				});

			});

			return this;
		}
	});
	
	return View;
});