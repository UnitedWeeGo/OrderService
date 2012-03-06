<?php
//IMPORTANT:
//Rename this file to configuration.php after having inserted all the correct db information
global $configuration;
$configuration['soap'] = "http://pog.weegoapp.com/services/pog.wsdl";
$configuration['homepage'] = "http://pog.weegoapp.com";
$configuration['revisionNumber'] = "";
$configuration['versionNumber'] = "3.0d";

$configuration['pdoDriver']	= 'mysql';
$configuration['setup_password'] = '';


// to enable automatic data encoding, run setup, go to the manage plugins tab and install the base64 plugin.
// then set db_encoding = 1 below.
// when enabled, db_encoding transparently encodes and decodes data to and from the database without any
// programmatic effort on your part.
$configuration['db_encoding'] = 0;

// edit the information below to match your database settings

$configuration['db']	= 'db22536_sxsw12';//'sxswapp';//'orderservice';		//	<- database name
$configuration['host'] 	= 'internal-db.s22536.gridserver.com';//'localhost';	//	<- database host
$configuration['user'] 	= 'db22536_case';//'root';//'orderservice';		//	<- database user
$configuration['pass']	= 'S@p13nt2010';//'root';//'etD7KJhmYQEXn6bq';		//	<- database password
$configuration['port']	= '3306';//'8889';		//	<- database port


//proxy settings - if you are behnd a proxy, change the settings below
$configuration['proxy_host'] = false;
$configuration['proxy_port'] = false;
$configuration['proxy_username'] = false;
$configuration['proxy_password'] = false;

//celltrust settings
$configuration['celltrust_service']	= 'https://gateway.celltrust.net/TxTNotify/TxTNotify';
$configuration['celltrust_user']	= 'SAPIENT';
$configuration['celltrust_password']	= 'password';
$configuration['celltrust_keyword']	= 'SAPIENT';

//plugin settings
$configuration['plugins_path'] = '/Users/nick/Documents/Adobe Flash Builder 4.5/OrderService/plugins';  //absolute path to plugins folder, e.g c:/mycode/test/plugins or /home/phpobj/public_html/plugins


?>