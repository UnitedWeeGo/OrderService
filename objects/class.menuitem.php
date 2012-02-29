<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `menuitem` (
	`menuitemid` int(11) NOT NULL auto_increment,
	`name` VARCHAR(255) NOT NULL,
	`itemprice` FLOAT NOT NULL,
	`orderid` int(11) NOT NULL,
	`categoryfriendlyname` VARCHAR(255) NOT NULL, INDEX(`orderid`), PRIMARY KEY  (`menuitemid`)) ENGINE=MyISAM;
*/

/**
* <b>MenuItem</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0d / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://pog.weegoapp.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=MenuItem&attributeList=array+%28%0A++0+%3D%3E+%27name%27%2C%0A++1+%3D%3E+%27itemPrice%27%2C%0A++2+%3D%3E+%27Order%27%2C%0A++3+%3D%3E+%27MenuItemOption%27%2C%0A++4+%3D%3E+%27categoryFriendlyName%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527FLOAT%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527BELONGSTO%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527HASMANY%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class MenuItem extends POG_Base
{
	public $menuitemId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $name;
	
	/**
	 * @var FLOAT
	 */
	public $itemPrice;
	
	/**
	 * @var INT(11)
	 */
	public $orderId;
	
	/**
	 * @var private array of MenuItemOption objects
	 */
	private $_menuitemoptionList = array();
	
	/**
	 * @var VARCHAR(255)
	 */
	public $categoryFriendlyName;
	
	public $pog_attribute_type = array(
		"menuitemId" => array('db_attributes' => array("NUMERIC", "INT")),
		"name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"itemPrice" => array('db_attributes' => array("NUMERIC", "FLOAT")),
		"Order" => array('db_attributes' => array("OBJECT", "BELONGSTO")),
		"MenuItemOption" => array('db_attributes' => array("OBJECT", "HASMANY")),
		"categoryFriendlyName" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
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
	
	function MenuItem($name='', $itemPrice='', $categoryFriendlyName='')
	{
		$this->name = $name;
		$this->itemPrice = $itemPrice;
		$this->_menuitemoptionList = array();
		$this->categoryFriendlyName = $categoryFriendlyName;
	}
	
	
	/**
	* Gets object from database
	* @param integer $menuitemId 
	* @return object $MenuItem
	*/
	function Get($menuitemId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `menuitem` where `menuitemid`=:menuitemId LIMIT 1";
		$this->pog_bind = array(
			':menuitemId' => intval($menuitemId)
		);
		$cursor = Database::ReaderPrepared($this->pog_query, $this->pog_bind, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->menuitemId = $row['menuitemid'];
			$this->name = $this->Decode($row['name']);
			$this->itemPrice = $this->Decode($row['itemprice']);
			$this->orderId = $row['orderid'];
			$this->categoryFriendlyName = $this->Decode($row['categoryfriendlyname']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $menuitemList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `menuitem` ";
		$menuitemList = Array();
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
			$sortBy = "menuitemid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$menuitem = new $thisObjectName();
			$menuitem->menuitemId = $row['menuitemid'];
			$menuitem->name = $this->Unescape($row['name']);
			$menuitem->itemPrice = $this->Unescape($row['itemprice']);
			$menuitem->orderId = $row['orderid'];
			$menuitem->categoryFriendlyName = $this->Unescape($row['categoryfriendlyname']);
			$menuitemList[] = $menuitem;
		}
		return $menuitemList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $menuitemId
	*/
	function Save($deep = true)
	{
		$connection = Database::Connect();
		$rows = 0;
		if (!empty($this->menuitemId))
		{
			$this->pog_query = "select `menuitemid` from `menuitem` where `menuitemid`=".$this->Quote($this->menuitemId, $connection)." LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `menuitem` set 
			`name`=:name,
			`itemprice`=:itemprice,
			`orderid`=:orderId,
			`categoryfriendlyname`=:categoryfriendlyname where `menuitemid`=:menuitemId";
		}
		else
		{
			$this->menuitemId = "";
			$this->pog_query = "insert into `menuitem` (`name`,`itemprice`,`orderid`,`categoryfriendlyname`,`menuitemid`) values (
			:name,
			:itemprice,
			:orderId,
			:categoryfriendlyname,
			:menuitemId)";
		}
		$this->pog_bind = array(
			':name' => $this->Encode($this->name),
			':itemprice' => $this->Encode($this->itemPrice),
			':orderId' => intval($this->orderId),
			':categoryfriendlyname' => $this->Encode($this->categoryFriendlyName),
			':menuitemId' => intval($this->menuitemId)
		);
		$insertId = Database::InsertOrUpdatePrepared($this->pog_query, $this->pog_bind, $connection);
		if ($this->menuitemId == "")
		{
			$this->menuitemId = $insertId;
		}
		if ($deep)
		{
			foreach ($this->_menuitemoptionList as $menuitemoption)
			{
				$menuitemoption->menuitemId = $this->menuitemId;
				$menuitemoption->Save($deep);
			}
		}
		return $this->menuitemId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $menuitemId
	*/
	function SaveNew($deep = false)
	{
		$this->menuitemId = '';
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
			$menuitemoptionList = $this->GetMenuitemoptionList();
			foreach ($menuitemoptionList as $menuitemoption)
			{
				$menuitemoption->Delete($deep, $across);
			}
		}
		$connection = Database::Connect();
		$this->pog_query = "delete from `menuitem` where `menuitemid`=".$this->Quote($this->menuitemId, $connection);
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
				$this->pog_query = "delete from `menuitem` where ";
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
	
	
	/**
	* Gets a list of MenuItemOption objects associated to this one
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array of MenuItemOption objects
	*/
	function GetMenuitemoptionList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$menuitemoption = new MenuItemOption();
		$fcv_array[] = array("menuitemId", "=", $this->menuitemId);
		$dbObjects = $menuitemoption->GetList($fcv_array, $sortBy, $ascending, $limit);
		return $dbObjects;
	}
	
	
	/**
	* Makes this the parent of all MenuItemOption objects in the MenuItemOption List array. Any existing MenuItemOption will become orphan(s)
	* @return null
	*/
	function SetMenuitemoptionList(&$list)
	{
		$this->_menuitemoptionList = array();
		$existingMenuitemoptionList = $this->GetMenuitemoptionList();
		foreach ($existingMenuitemoptionList as $menuitemoption)
		{
			$menuitemoption->menuitemId = '';
			$menuitemoption->Save(false);
		}
		$this->_menuitemoptionList = $list;
	}
	
	
	/**
	* Associates the MenuItemOption object to this one
	* @return 
	*/
	function AddMenuitemoption(&$menuitemoption)
	{
		$menuitemoption->menuitemId = $this->menuitemId;
		$found = false;
		foreach($this->_menuitemoptionList as $menuitemoption2)
		{
			if ($menuitemoption->menuitemoptionId > 0 && $menuitemoption->menuitemoptionId == $menuitemoption2->menuitemoptionId)
			{
				$found = true;
				break;
			}
		}
		if (!$found)
		{
			$this->_menuitemoptionList[] = $menuitemoption;
		}
	}
}
?>