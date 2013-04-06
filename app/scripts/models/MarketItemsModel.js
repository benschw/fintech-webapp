/*global define */
define(['underscore', 'backbone'], function (_, Backbone) {
	'use strict';

	var Model = Backbone.Model.extend({
		defaults: {
			title : 'Market Items',
			items : [{
				title : 'Austin Pets Alive'
			}, {
				title : 'Red Cross'
			}]
		}
	});

	return Model;
});