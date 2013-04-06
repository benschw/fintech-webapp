define(function(){

this["JST"] = this["JST"] || {};

this["JST"]["app/scripts/tpl/about.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="container"><div class="hero-unit">\n<h1>About Us</h1>\n<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\n</div></div>';

}
return __p
};

this["JST"]["app/scripts/tpl/contact.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="container">\n<div class="hero-unit">\n<h1>Contact Us</h1>\n<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\n</div>\n</div>';

}
return __p
};

this["JST"]["app/scripts/tpl/help.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="container">\n<div class="hero-unit">\n<h1>Help</h1>\n<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\n</div>\n</div>';

}
return __p
};

this["JST"]["app/scripts/tpl/home.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="container"><!-- Main hero unit for a primary marketing message or call to action -->\n<div class="hero-unit">\n<h1>' +
((__t = ( title )) == null ? '' : __t) +
'</h1>\n<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\n<p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>\n</div><!-- Example row of columns -->\n<div class="row">\n<div class="span4">\n<h2 id="test">Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details &raquo;</a></p>\n</div>\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details &raquo;</a></p>\n</div>\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\n<p><a class="btn" href="#">View details &raquo;</a></p>\n</div>\n</div></div> <!-- /container -->';

}
return __p
};

this["JST"]["app/scripts/tpl/nav.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
function print() { __p += __j.call(arguments, '') }
with (obj) {
__p += '<div class="navbar navbar-inverse navbar-fixed-top">\n<div class="navbar-inner">\n<div class="container">\n<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">\n<span class="icon-bar"></span>\n<span class="icon-bar"></span>\n<span class="icon-bar"></span>\n</button>\n<a class="brand" href="/">FundraiserMarket</a>\n<div class="nav-collapse collapse">\n<ul class="nav">\n';
 if (loggedIn) { ;
__p += '\n<li ' +
((__t = ( activePage == 'dashboard_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/' +
((__t = ( userName )) == null ? '' : __t) +
'">Home</a></li>\n<li ' +
((__t = ( activePage == 'new_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/new-markets">New</a></li>\n<li ' +
((__t = ( activePage == 'top_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/top-markets">Top</a></li>\n';
 } else { ;
__p += '\n<!-- <li ' +
((__t = ( activePage == 'home_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/">Home</a></li> -->\n';
 } ;
__p += '\n</ul>';
 if (loggedIn) { ;
__p += '\n<ul class="nav pull-right">\n<li class="dropdown">\n<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">' +
((__t = ( email )) == null ? '' : __t) +
' <b class="caret"></b></a>\n<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">\n<!-- <li role="presentation" class="divider"></li> -->\n<li role="presentation"><a role="menuitem" tabindex="-1" href="/' +
((__t = ( userName )) == null ? '' : __t) +
'/settings">My Account</a></li>\n<li role="presentation"><a role="menuitem" tabindex="-1" href="/help">Help</a></li>\n<li role="presentation"><a role="menuitem" tabindex="-1" href="/api/auth/logout">Logout</a></li>\n</ul>\n</li>\n</ul>';
 } else { ;
__p += '\n<div class="navbar-text pull-right">\n<a href="/api/auth/login"><img src="/images/fb-login.png" /></a>\n</div>\n';
 }  ;
__p += '\n</div>\n</div>\n</div>\n</div>';

}
return __p
};

this["JST"]["app/scripts/tpl/settings.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="hero-unit">\n<h1>Hello, world!</h1>\n<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\n<p><a href="#" class="btn btn-primary btn-large">Learn more »</a></p>\n</div>\n<div class="row-fluid">\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details »</a></p>\n</div><!--/span-->\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details »</a></p>\n</div><!--/span-->\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details »</a></p>\n</div><!--/span-->\n</div><!--/row-->\n<div class="row-fluid">\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details »</a></p>\n</div><!--/span-->\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details »</a></p>\n</div><!--/span-->\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details »</a></p>\n</div><!--/span-->\n</div><!--/row-->';

}
return __p
};

this["JST"]["app/scripts/tpl/userNav.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="container">\n<div class="row-fluid">\n<div class="span3">\n<div class="well sidebar-nav">\n<ul class="nav nav-list">\n<li class="nav-header">Sidebar</li>\n<li ' +
((__t = ( activePage == 'settings_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/' +
((__t = ( userName )) == null ? '' : __t) +
'/settings">Settings</a></li>\n<li ' +
((__t = ( activePage == 'markets_run_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/' +
((__t = ( userName )) == null ? '' : __t) +
'/my-markets">Markets I Run</a></li>\n<li ' +
((__t = ( activePage == 'markets_in_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'> <a href="/' +
((__t = ( userName )) == null ? '' : __t) +
'/markets">Markets I\'m In</a></li>\n<!--           <li class="nav-header">Sidebar</li> -->\n</ul>\n</div><!--/.well -->\n</div><!--/span-->\n<div id="userContent" class="span9"></div><!--/span-->\n</div><!--/row--></div>';

}
return __p
};

  return this["JST"];

});