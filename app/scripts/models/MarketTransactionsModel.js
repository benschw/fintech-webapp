/*global define */
define(['underscore', 'backbone', 'models/MarketTransactionModel'], function (_, Backbone, MarketTransactionModel) {
	'use strict';

	var Model = Backbone.Collection.extend({
		model : MarketTransactionModel,
		defaults: {
		},
        url: function () {
            return '/api/market/' + this.marketId + '/transactions';
        }

	});

	return Model;
});