<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `customer` (
	`customerid` int(11) NOT NULL auto_increment,
	`name` VARCHAR(255) NOT NULL,
	`phonenumber` VARCHAR(255) NOT NULL,
	`orderid` int(11) NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL, INDEX(`orderid`), PRIMARY KEY  (`customerid`)) ENGINE=MyISAM;
*/

/**
* <b>Customer</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0d / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://pog.weegoapp.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=Customer&attributeList=array+%28%0A++0+%3D%3E+%27name%27%2C%0A++1+%3D%3E+%27phoneNumber%27%2C%0A++2+%3D%3E+%27Order%27%2C%0A++3+%3D%3E+%27title%27%2C%0A++4+%3D%3E+%27email%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527BELONGSTO%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class Customer extends POG_Base
{
	public $customerId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $name;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $phoneNumber;
	
	/**
	 * @var INT(11)
	 */
	public $orderId;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $title;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $email;
	
	public $pog_attribute_type = array(
		"customerId" => array('db_attributes' => array("NUMERIC", "INT")),
		"name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"phoneNumber" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"Order" => array('db_attributes' => array("OBJECT", "BELONGSTO")),
		"title" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"email" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
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
	
	function Customer($name='', $phoneNumber='', $title='', $email='')
	{
		$this->name = $name;
		$this->phoneNumber = $phoneNumber;
		$this->title = $title;
		$this->email = $email;
	}
	
	
	/**
	* Gets object from database
	* @param integer $customerId 
	* @return object $Customer
	*/
	function Get($customerId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `customer` where `customerid`=:customerId LIMIT 1";
		$this->pog_bind = array(
			':customerId' => intval($customerId)
		);
		$cursor = Database::ReaderPrepared($this->pog_query, $this->pog_bind, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->customerId = $row['customerid'];
			$this->name = $this->Decode($row['name']);
			$this->phoneNumber = $this->Decode($row['phonenumber']);
			$this->orderId = $row['orderid'];
			$this->title = $this->Decode($row['title']);
			$this->email = $this->Decode($row['email']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $customerList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `customer` ";
		$customerList = Array();
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
			$sortBy = "customerid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$customer = new $thisObjectName();
			$customer->customerId = $row['customerid'];
			$customer->name = $this->Unescape($row['name']);
			$customer->phoneNumber = $this->Unescape($row['phonenumber']);
			$customer->orderId = $row['orderid'];
			$customer->title = $this->Unescape($row['title']);
			$customer->email = $this->Unescape($row['email']);
			$customerList[] = $customer;
		}
		return $customerList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $customerId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
		if (!empty($this->customerId))
		{
			$this->pog_query = "select `customerid` from `customer` where `customerid`=".$this->Quote($this->customerId, $connection)." LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `customer` set 
			`name`=:name,
			`phonenumber`=:phonenumber,
			`orderid`=:orderId,
			`title`=:title,
			`email`=:email where `customerid`=:customerId";
		}
		else
		{
			$this->customerId = "";
			$this->pog_query = "insert into `customer` (`name`,`phonenumber`,`orderid`,`title`,`email`,`customerid`) values (
			:name,
			:phonenumber,
			:orderId,
			:title,
			:email,
			:customerId)";
		}
		$this->pog_bind = array(
			':name' => $this->Encode($this->name),
			':phonenumber' => $this->Encode($this->phoneNumber),
			':orderId' => intval($this->orderId),
			':title' => $this->Encode($this->title),
			':email' => $this->Encode($this->email),
			':customerId' => intval($this->customerId)
		);
		$insertId = Database::InsertOrUpdatePrepared($this->pog_query, $this->pog_bind, $connection);
		if ($this->customerId == "")
		{
			$this->customerId = $insertId;
		}
		return $this->customerId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $customerId
	*/
	function SaveNew()
	{
		$this->customerId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `customer` where `customerid`=".$this->Quote($this->customerId, $connection);
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$this->pog_query = "delete from `customer` where ";
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
	
	
	/**
	* Associates the Order object to this one
	* @return boolean
	*/
	function GetOrder()
	{
		$order = new Order();
		return $order->Get($this->orderId);
	}
	
	
	/**
	* Associates the Order object to this one
	* @return 
	*/
	function SetOrder(&$order)
	{
		$this->orderId = $order->orderId;
	}
}
?>