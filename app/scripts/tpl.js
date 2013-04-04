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

this["JST"]["app/scripts/tpl/home.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape;
with (obj) {
__p += '<div class="container"><!-- Main hero unit for a primary marketing message or call to action -->\n<div class="hero-unit">\n<h1>Hello, ' +
((__t = ( title )) == null ? '' : __t) +
'!</h1>\n<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>\n<p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>\n</div><!-- Example row of columns -->\n<div class="row">\n<div class="span4">\n<h2 id="test">Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details &raquo;</a></p>\n</div>\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\n<p><a class="btn" href="#">View details &raquo;</a></p>\n</div>\n<div class="span4">\n<h2>Heading</h2>\n<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\n<p><a class="btn" href="#">View details &raquo;</a></p>\n</div>\n</div><hr><footer>\n<p>&copy; Company 2013</p>\n</footer></div> <!-- /container -->';

}
return __p
};

this["JST"]["app/scripts/tpl/nav.html"] = function(obj) {
obj || (obj = {});
var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
function print() { __p += __j.call(arguments, '') }
with (obj) {
__p += '<div class="navbar navbar-inverse navbar-fixed-top">\n<div class="navbar-inner">\n<div class="container">\n<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">\n<span class="icon-bar"></span>\n<span class="icon-bar"></span>\n<span class="icon-bar"></span>\n</button>\n<a class="brand" href="#">Scalpable</a>\n<div class="nav-collapse collapse">\n<ul class="nav">\n<li ' +
((__t = ( activePage == 'home_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/">Home</a></li>\n<li ' +
((__t = ( activePage == 'about_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/about">About</a></li>\n<li ' +
((__t = ( activePage == 'contact_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/contact">Contact</a></li>\n';
 if (loggedIn) { ;
__p += '\n<li ' +
((__t = ( activePage == 'dashboard_page' ? 'class="active"' : '' )) == null ? '' : __t) +
'><a href="/' +
((__t = ( userName )) == null ? '' : __t) +
'">Dashboard</a></li>\n';
 }  ;
__p += '\n</ul>';
 if (loggedIn) { ;
__p += '\n<ul class="nav pull-right">\n<li class="dropdown">\n<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">' +
((__t = ( email )) == null ? '' : __t) +
' <b class="caret"></b></a>\n<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">\n<li role="presentation"><a role="menuitem" tabindex="-1" href="/' +
((__t = ( userName )) == null ? '' : __t) +
'">Dashboard</a></li>\n<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Help</a></li>\n<li role="presentation" class="divider"></li>\n<li role="presentation"><a role="menuitem" tabindex="-1" href="/' +
((__t = ( userName )) == null ? '' : __t) +
'/settings">Settings</a></li>\n<li role="presentation"><a role="menuitem" tabindex="-1" href="/api/auth/logout">Logout</a></li>\n</ul>\n</li>\n</ul>';
 } else { ;
__p += '\n<div class="navbar-text pull-right">\n<a href="/api/auth/login"><img src="/images/fb-login.png" /></a>\n</div>\n';
 }  ;
__p += '\n</div>\n</div>\n</div>\n</div>';

}
return __p
};

  return this["JST"];

});