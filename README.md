
## Env Setup
	$ npm install
	$ bower install
	$ composer install




## Build

	$ ant build
	$ grunt build
	
	
	
## Vhost Example


	<VirtualHost *:80>
	    DocumentRoot "/Users/ben.schwartz/dev/webapp-fintech/dist"
	    ServerName fintech.local
	    SetEnv FLIGLIO_ENV LOCAL
	    <Directory "/Users/ben.schwartz/dev/webapp-fintech/dist">
	        RewriteEngine On
	        RewriteCond %{SCRIPT_FILENAME} -f [OR]
	        RewriteCond %{SCRIPT_FILENAME} -d
	        RewriteRule .+ - [L]

	        RewriteRule ^api/(.*)$ /api.php?fliglio_request=/api/$1 [L,QSA]
	        RewriteRule ^(.*)$ /index.html#$1 [L,QSA]

	        AllowOverride None
	        Order allow,deny
	        Allow from all
	    </Directory>
	</VirtualHost>