/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			title: 'Default Market Item',
			marketId: 0
		}
	});

	return Model;
});