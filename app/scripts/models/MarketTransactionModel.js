/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			id: 1123,
			fbId: 100401316,
			marketId: 1,
			userId: 3,
			time: 12345678,
			message: 'Purchased a gift card'
		}
	});

	return Model;
});