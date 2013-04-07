/*global define */
define(['underscore', 'backbone', 'models/MarketItemModel'], function (_, Backbone, MarketItemModel) {
	'use strict';

	var Model = Backbone.Collection.extend({
		title : 'Market Items',
		model : MarketItemModel,
		url : '/api/markets',
		defaults: {
			title : 'Market Items'
		}
	});

	return Model;
});