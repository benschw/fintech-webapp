/*global define */
define(['underscore', 'backbone', 'models/MarketTransactionModel'], function (_, Backbone, MarketTransactionModel) {
	'use strict';

	var Model = Backbone.Collection.extend({
		model : MarketTransactionModel,
		defaults: {
			marketId: 1
		},
		url: function () {
			return '/api/market/' + this.marketId + '/transactions';
		}
	});

	return Model;
});