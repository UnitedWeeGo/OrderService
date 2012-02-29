<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `instance` (
	`instanceid` int(11) NOT NULL auto_increment,
	`friendlyappname` VARCHAR(255) NOT NULL,
	`twilioaccountsid` VARCHAR(255) NOT NULL,
	`twilioauthtoken` VARCHAR(255) NOT NULL,
	`twiliophonenumber` VARCHAR(255) NOT NULL,
	`twiliosmsmessage` VARCHAR(255) NOT NULL, PRIMARY KEY  (`instanceid`)) ENGINE=MyISAM;
*/

/**
* <b>Instance</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0d / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://pog.weegoapp.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=Instance&attributeList=array+%28%0A++0+%3D%3E+%27friendlyAppName%27%2C%0A++1+%3D%3E+%27twilioAccountSID%27%2C%0A++2+%3D%3E+%27twilioAuthToken%27%2C%0A++3+%3D%3E+%27twilioPhoneNumber%27%2C%0A++4+%3D%3E+%27twilioSMSMessage%27%2C%0A++5+%3D%3E+%27Order%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527HASMANY%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class Instance extends POG_Base
{
	public $instanceId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $friendlyAppName;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $twilioAccountSID;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $twilioAuthToken;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $twilioPhoneNumber;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $twilioSMSMessage;
	
	/**
	 * @var private array of Order objects
	 */
	private $_orderList = array();
	
	public $pog_attribute_type = array(
		"instanceId" => array('db_attributes' => array("NUMERIC", "INT")),
		"friendlyAppName" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"twilioAccountSID" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"twilioAuthToken" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"twilioPhoneNumber" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"twilioSMSMessage" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Order" => array('db_attributes' => array("OBJECT", "HASMANY")),
		);
	public $pog_query;
	public $pog_bind = array();
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function Instance($friendlyAppName='', $twilioAccountSID='', $twilioAuthToken='', $twilioPhoneNumber='', $twilioSMSMessage='')
	{
		$this->friendlyAppName = $friendlyAppName;
		$this->twilioAccountSID = $twilioAccountSID;
		$this->twilioAuthToken = $twilioAuthToken;
		$this->twilioPhoneNumber = $twilioPhoneNumber;
		$this->twilioSMSMessage = $twilioSMSMessage;
		$this->_orderList = array();
	}
	
	
	/**
	* Gets object from database
	* @param integer $instanceId 
	* @return object $Instance
	*/
	function Get($instanceId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `instance` where `instanceid`=:instanceId LIMIT 1";
		$this->pog_bind = array(
			':instanceId' => intval($instanceId)
		);
		$cursor = Database::ReaderPrepared($this->pog_query, $this->pog_bind, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->instanceId = $row['instanceid'];
			$this->friendlyAppName = $this->Decode($row['friendlyappname']);
			$this->twilioAccountSID = $this->Decode($row['twilioaccountsid']);
			$this->twilioAuthToken = $this->Decode($row['twilioauthtoken']);
			$this->twilioPhoneNumber = $this->Decode($row['twiliophonenumber']);
			$this->twilioSMSMessage = $this->Decode($row['twiliosmsmessage']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $instanceList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `instance` ";
		$instanceList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : $this->Quote($fcv_array[$i][2], $connection);
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : $this->Quote($fcv_array[$i][2], $connection);
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : $this->Quote($fcv_array[$i][2], $connection);
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "instanceid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$instance = new $thisObjectName();
			$instance->instanceId = $row['instanceid'];
			$instance->friendlyAppName = $this->Unescape($row['friendlyappname']);
			$instance->twilioAccountSID = $this->Unescape($row['twilioaccountsid']);
			$instance->twilioAuthToken = $this->Unescape($row['twilioauthtoken']);
			$instance->twilioPhoneNumber = $this->Unescape($row['twiliophonenumber']);
			$instance->twilioSMSMessage = $this->Unescape($row['twiliosmsmessage']);
			$instanceList[] = $instance;
		}
		return $instanceList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $instanceId
	*/
	function Save($deep = true)
	{
		$connection = Database::Connect();
		$rows = 0;
		if (!empty($this->instanceId))
		{
			$this->pog_query = "select `instanceid` from `instance` where `instanceid`=".$this->Quote($this->instanceId, $connection)." LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `instance` set 
			`friendlyappname`=:friendlyappname,
			`twilioaccountsid`=:twilioaccountsid,
			`twilioauthtoken`=:twilioauthtoken,
			`twiliophonenumber`=:twiliophonenumber,
			`twiliosmsmessage`=:twiliosmsmessage where `instanceid`=:instanceId";
		}
		else
		{
			$this->instanceId = "";
			$this->pog_query = "insert into `instance` (`friendlyappname`,`twilioaccountsid`,`twilioauthtoken`,`twiliophonenumber`,`twiliosmsmessage`,`instanceid`) values (
			:friendlyappname,
			:twilioaccountsid,
			:twilioauthtoken,
			:twiliophonenumber,
			:twiliosmsmessage,
			:instanceId)";
		}
		$this->pog_bind = array(
			':friendlyappname' => $this->Encode($this->friendlyAppName),
			':twilioaccountsid' => $this->Encode($this->twilioAccountSID),
			':twilioauthtoken' => $this->Encode($this->twilioAuthToken),
			':twiliophonenumber' => $this->Encode($this->twilioPhoneNumber),
			':twiliosmsmessage' => $this->Encode($this->twilioSMSMessage),
			':instanceId' => intval($this->instanceId)
		);
		$insertId = Database::InsertOrUpdatePrepared($this->pog_query, $this->pog_bind, $connection);
		if ($this->instanceId == "")
		{
			$this->instanceId = $insertId;
		}
		if ($deep)
		{
			foreach ($this->_orderList as $order)
			{
				$order->instanceId = $this->instanceId;
				$order->Save($deep);
			}
		}
		return $this->instanceId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $instanceId
	*/
	function SaveNew($deep = false)
	{
		$this->instanceId = '';
		return $this->Save($deep);
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete($deep = false, $across = false)
	{
		if ($deep)
		{
			$orderList = $this->GetOrderList();
			foreach ($orderList as $order)
			{
				$order->Delete($deep, $across);
			}
		}
		$connection = Database::Connect();
		$this->pog_query = "delete from `instance` where `instanceid`=".$this->Quote($this->instanceId, $connection);
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array, $deep = false, $across = false)
	{
		if (sizeof($fcv_array) > 0)
		{
			if ($deep || $across)
			{
				$objectList = $this->GetList($fcv_array);
				foreach ($objectList as $object)
				{
					$object->Delete($deep, $across);
				}
			}
			else
			{
				$connection = Database::Connect();
				$this->pog_query = "delete from `instance` where ";
				for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
				{
					if (sizeof($fcv_array[$i]) == 1)
					{
						$this->pog_query .= " ".$fcv_array[$i][0]." ";
						continue;
					}
					else
					{
						if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
						{
							$this->pog_query .= " AND ";
						}
						if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
						{
							if ($GLOBALS['configuration']['db_encoding'] == 1)
							{
								$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : $this->Quote($fcv_array[$i][2], $connection);
								$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
							}
							else
							{
								$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : $this->Quote($fcv_array[$i][2], $connection);
								$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
							}
						}
						else
						{
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$this->Quote($fcv_array[$i][2], $connection);
						}
					}
				}
				return Database::NonQuery($this->pog_query, $connection);
			}
		}
	}
	
	
	/**
	* Gets a list of Order objects associated to this one
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array of Order objects
	*/
	function GetOrderList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$order = new Order();
		$fcv_array[] = array("instanceId", "=", $this->instanceId);
		$dbObjects = $order->GetList($fcv_array, $sortBy, $ascending, $limit);
		return $dbObjects;
	}
	
	
	/**
	* Makes this the parent of all Order objects in the Order List array. Any existing Order will become orphan(s)
	* @return null
	*/
	function SetOrderList(&$list)
	{
		$this->_orderList = array();
		$existingOrderList = $this->GetOrderList();
		foreach ($existingOrderList as $order)
		{
			$order->instanceId = '';
			$order->Save(false);
		}
		$this->_orderList = $list;
	}
	
	
	/**
	* Associates the Order object to this one
	* @return 
	*/
	function AddOrder(&$order)
	{
		$order->instanceId = $this->instanceId;
		$found = false;
		foreach($this->_orderList as $order2)
		{
			if ($order->orderId > 0 && $order->orderId == $order2->orderId)
			{
				$found = true;
				break;
			}
		}
		if (!$found)
		{
			$this->_orderList[] = $order;
		}
	}
}
?>