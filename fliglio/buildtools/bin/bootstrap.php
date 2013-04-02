<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';

require_once dirname(dirname(__FILE__)) . '/lib/Colors.php';

require_once dirname(dirname(__FILE__)) . '/lib/Fliglio_BuildTools_DepLib.php';
require_once dirname(dirname(__FILE__)) . '/lib/Fliglio_BuildTools_ParserCollector.php';

require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CheckSyntaxDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CheckNamingDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CheckDepsDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CacheRoutesDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CachePackageIndexDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CacheConfigsDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CachePermissionsDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CachePathConfigDriver.php';
require_once dirname(dirname(__FILE__)) . '/driver/Fliglio_BuildTools_CheckCommandsDriver.php';


