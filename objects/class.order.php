<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `order` (
	`orderid` int(11) NOT NULL auto_increment,
	`orderplaced` TIMESTAMP NOT NULL,
	`ordercompletedtime` TIMESTAMP NOT NULL,
	`instanceid` int(11) NOT NULL,
	`completed` TINYINT NOT NULL, INDEX(`instanceid`), PRIMARY KEY  (`orderid`)) ENGINE=MyISAM;
*/

/**
* <b>Order</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0d / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://pog.weegoapp.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=Order&attributeList=array+%28%0A++0+%3D%3E+%27orderPlaced%27%2C%0A++1+%3D%3E+%27orderCompletedTime%27%2C%0A++2+%3D%3E+%27MenuItem%27%2C%0A++3+%3D%3E+%27Customer%27%2C%0A++4+%3D%3E+%27Instance%27%2C%0A++5+%3D%3E+%27completed%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527TIMESTAMP%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527TIMESTAMP%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527HASMANY%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527HASMANY%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527BELONGSTO%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527TINYINT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class Order extends POG_Base
{
	public $orderId = '';

	/**
	 * @var TIMESTAMP
	 */
	public $orderPlaced;
	
	/**
	 * @var TIMESTAMP
	 */
	public $orderCompletedTime;
	
	/**
	 * @var private array of MenuItem objects
	 */
	private $_menuitemList = array();
	
	/**
	 * @var private array of Customer objects
	 */
	private $_customerList = array();
	
	/**
	 * @var INT(11)
	 */
	public $instanceId;
	
	/**
	 * @var TINYINT
	 */
	public $completed;
	
	public $pog_attribute_type = array(
		"orderId" => array('db_attributes' => array("NUMERIC", "INT")),
		"orderPlaced" => array('db_attributes' => array("NUMERIC", "TIMESTAMP")),
		"orderCompletedTime" => array('db_attributes' => array("NUMERIC", "TIMESTAMP")),
		"MenuItem" => array('db_attributes' => array("OBJECT", "HASMANY")),
		"Customer" => array('db_attributes' => array("OBJECT", "HASMANY")),
		"Instance" => array('db_attributes' => array("OBJECT", "BELONGSTO")),
		"completed" => array('db_attributes' => array("NUMERIC", "TINYINT")),
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
	
	function Order($orderPlaced='', $orderCompletedTime='', $completed='')
	{
		$this->orderPlaced = $orderPlaced;
		$this->orderCompletedTime = $orderCompletedTime;
		$this->_menuitemList = array();
		$this->_customerList = array();
		$this->completed = $completed;
	}
	
	
	/**
	* Gets object from database
	* @param integer $orderId 
	* @return object $Order
	*/
	function Get($orderId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `order` where `orderid`=:orderId LIMIT 1";
		$this->pog_bind = array(
			':orderId' => intval($orderId)
		);
		$cursor = Database::ReaderPrepared($this->pog_query, $this->pog_bind, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->orderId = $row['orderid'];
			$this->orderPlaced = $row['orderplaced'];
			$this->orderCompletedTime = $row['ordercompletedtime'];
			$this->instanceId = $row['instanceid'];
			$this->completed = $this->Decode($row['completed']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $orderList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `order` ";
		$orderList = Array();
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
			$sortBy = "orderid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$order = new $thisObjectName();
			$order->orderId = $row['orderid'];
			$order->orderPlaced = $row['orderplaced'];
			$order->orderCompletedTime = $row['ordercompletedtime'];
			$order->instanceId = $row['instanceid'];
			$order->completed = $this->Unescape($row['completed']);
			$orderList[] = $order;
		}
		return $orderList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $orderId
	*/
	function Save($deep = true)
	{
		$connection = Database::Connect();
		$rows = 0;
		if (!empty($this->orderId))
		{
			$this->pog_query = "select `orderid` from `order` where `orderid`=".$this->Quote($this->orderId, $connection)." LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `order` set 
			`orderplaced`=:orderplaced,
			`ordercompletedtime`=:ordercompletedtime,
			`instanceid`=:instanceId,
			`completed`=:completed where `orderid`=:orderId";
		}
		else
		{
			$this->orderId = "";
			$this->pog_query = "insert into `order` (`orderplaced`,`ordercompletedtime`,`instanceid`,`completed`,`orderid`) values (
			:orderplaced,
			:ordercompletedtime,
			:instanceId,
			:completed,
			:orderId)";
		}
		$this->pog_bind = array(
			':orderplaced' => $this->orderPlaced,
			':ordercompletedtime' => $this->orderCompletedTime,
			':instanceId' => intval($this->instanceId),
			':completed' => $this->Encode($this->completed),
			':orderId' => intval($this->orderId)
		);
		$insertId = Database::InsertOrUpdatePrepared($this->pog_query, $this->pog_bind, $connection);
		if ($this->orderId == "")
		{
			$this->orderId = $insertId;
		}
		if ($deep)
		{
			foreach ($this->_menuitemList as $menuitem)
			{
				$menuitem->orderId = $this->orderId;
				$menuitem->Save($deep);
			}
			foreach ($this->_customerList as $customer)
			{
				$customer->orderId = $this->orderId;
				$customer->Save($deep);
			}
		}
		return $this->orderId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $orderId
	*/
	function SaveNew($deep = false)
	{
		$this->orderId = '';
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
			$menuitemList = $this->GetMenuitemList();
			foreach ($menuitemList as $menuitem)
			{
				$menuitem->Delete($deep, $across);
			}
			$customerList = $this->GetCustomerList();
			foreach ($customerList as $customer)
			{
				$customer->Delete($deep, $across);
			}
		}
		$connection = Database::Connect();
		$this->pog_query = "delete from `order` where `orderid`=".$this->Quote($this->orderId, $connection);
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
				$this->pog_query = "delete from `order` where ";
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
	* Gets a list of MenuItem objects associated to this one
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array of MenuItem objects
	*/
	function GetMenuitemList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$menuitem = new MenuItem();
		$fcv_array[] = array("orderId", "=", $this->orderId);
		$dbObjects = $menuitem->GetList($fcv_array, $sortBy, $ascending, $limit);
		return $dbObjects;
	}
	
	
	/**
	* Makes this the parent of all MenuItem objects in the MenuItem List array. Any existing MenuItem will become orphan(s)
	* @return null
	*/
	function SetMenuitemList(&$list)
	{
		$this->_menuitemList = array();
		$existingMenuitemList = $this->GetMenuitemList();
		foreach ($existingMenuitemList as $menuitem)
		{
			$menuitem->orderId = '';
			$menuitem->Save(false);
		}
		$this->_menuitemList = $list;
	}
	
	
	/**
	* Associates the MenuItem object to this one
	* @return 
	*/
	function AddMenuitem(&$menuitem)
	{
		$menuitem->orderId = $this->orderId;
		$found = false;
		foreach($this->_menuitemList as $menuitem2)
		{
			if ($menuitem->menuitemId > 0 && $menuitem->menuitemId == $menuitem2->menuitemId)
			{
				$found = true;
				break;
			}
		}
		if (!$found)
		{
			$this->_menuitemList[] = $menuitem;
		}
	}
	
	
	/**
	* Gets a list of Customer objects associated to this one
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array of Customer objects
	*/
	function GetCustomerList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$customer = new Customer();
		$fcv_array[] = array("orderId", "=", $this->orderId);
		$dbObjects = $customer->GetList($fcv_array, $sortBy, $ascending, $limit);
		return $dbObjects;
	}
	
	
	/**
	* Makes this the parent of all Customer objects in the Customer List array. Any existing Customer will become orphan(s)
	* @return null
	*/
	function SetCustomerList(&$list)
	{
		$this->_customerList = array();
		$existingCustomerList = $this->GetCustomerList();
		foreach ($existingCustomerList as $customer)
		{
			$customer->orderId = '';
			$customer->Save(false);
		}
		$this->_customerList = $list;
	}
	
	
	/**
	* Associates the Customer object to this one
	* @return 
	*/
	function AddCustomer(&$customer)
	{
		$customer->orderId = $this->orderId;
		$found = false;
		foreach($this->_customerList as $customer2)
		{
			if ($customer->customerId > 0 && $customer->customerId == $customer2->customerId)
			{
				$found = true;
				break;
			}
		}
		if (!$found)
		{
			$this->_customerList[] = $customer;
		}
	}
	
	
	/**
	* Associates the Instance object to this one
	* @return boolean
	*/
	function GetInstance()
	{
		$instance = new Instance();
		return $instance->Get($this->instanceId);
	}
	
	
	/**
	* Associates the Instance object to this one
	* @return 
	*/
	function SetInstance(&$instance)
	{
		$this->instanceId = $instance->instanceId;
	}
}
?>