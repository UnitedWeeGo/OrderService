<?php

require_once "../configuration.php";
require_once "response.php";
foreach(glob("../objects/*.php") as $class_filename) {
	require_once($class_filename);
}

date_default_timezone_set('GMT');

class ReqBase
{
	private $timestamp;
	public $dataObj;
	
	function __construct() {
		$this->timestamp = microtime(true);
		$this->dataObj = $this->genDataObj();
   	}
   	
	/**
	* gets the current unix timestamp as a float
	* @return Float
	*/
   	function getTimeStamp()
   	{
   		return date('Y-m-d H:i:s', $this->timestamp);
   	}
	
/**
	* Populates a data object with either get or post data
	* @return Array
	*/
	function genDataObj()
	{
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		$data;
		switch ($request_method)
		{
			case 'get':
				$data = $_GET;
				break;
			case 'post':
				$this->stripmagicquotes(); // tests to see if magic quotes is on, and strips slashes if it is
				$data = $_POST;
				break;
		}
		return $data;
	}
	
	function stripmagicquotes()
	{
		if (get_magic_quotes_gpc()) {

			if (!function_exists('stripslashes_gpc'))
			{
			    function stripslashes_gpc(&$value)
			    {
			        $value = stripslashes($value);
			    }
			}
//		    array_walk_recursive($_GET, 'stripslashes_gpc');
		    array_walk_recursive($_POST, 'stripslashes_gpc');
//		    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
//		    array_walk_recursive($_REQUEST, 'stripslashes_gpc');
		}
	}
}


?>