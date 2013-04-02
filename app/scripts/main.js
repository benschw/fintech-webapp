require.config({
	paths: {
		jquery: '../components/jquery/jquery',
		backbone: '../components/backbone/backbone',
		'backbone.localStorage': '../components/backbone.localStorage/backbone.localStorage',
		underscore: '../components/underscore/underscore',
		bootstrap: 'vendor/bootstrap'
	},
	shim: {
		bootstrap: {
			deps: ['jquery'],
			exports: 'jquery'
		},
		underscore: {
			exports: '_'
		},
		backbone: {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		},
		'backbone.localStorage': {
			deps: ['backbone'],
			exports: 'Backbone'
		}
	}
});

require(['app', 'bootstrap'], function (app, bootstrap) {
    'use strict';
    // use app here

	app.initialize();

});