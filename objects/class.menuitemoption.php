<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `menuitemoption` (
	`menuitemoptionid` int(11) NOT NULL auto_increment,
	`menuitemid` int(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`addlcost` FLOAT NOT NULL, INDEX(`menuitemid`), PRIMARY KEY  (`menuitemoptionid`)) ENGINE=MyISAM;
*/

/**
* <b>MenuItemOption</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0d / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://pog.weegoapp.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=MenuItemOption&attributeList=array+%28%0A++0+%3D%3E+%27MenuItem%27%2C%0A++1+%3D%3E+%27name%27%2C%0A++2+%3D%3E+%27addlCost%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527BELONGSTO%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527FLOAT%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class MenuItemOption extends POG_Base
{
	public $menuitemoptionId = '';

	/**
	 * @var INT(11)
	 */
	public $menuitemId;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $name;
	
	/**
	 * @var FLOAT
	 */
	public $addlCost;
	
	public $pog_attribute_type = array(
		"menuitemoptionId" => array('db_attributes' => array("NUMERIC", "INT")),
		"MenuItem" => array('db_attributes' => array("OBJECT", "BELONGSTO")),
		"name" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"addlCost" => array('db_attributes' => array("NUMERIC", "FLOAT")),
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
	
	function MenuItemOption($name='', $addlCost='')
	{
		$this->name = $name;
		$this->addlCost = $addlCost;
	}
	
	
	/**
	* Gets object from database
	* @param integer $menuitemoptionId 
	* @return object $MenuItemOption
	*/
	function Get($menuitemoptionId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `menuitemoption` where `menuitemoptionid`=:menuitemoptionId LIMIT 1";
		$this->pog_bind = array(
			':menuitemoptionId' => intval($menuitemoptionId)
		);
		$cursor = Database::ReaderPrepared($this->pog_query, $this->pog_bind, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->menuitemoptionId = $row['menuitemoptionid'];
			$this->menuitemId = $row['menuitemid'];
			$this->name = $this->Decode($row['name']);
			$this->addlCost = $this->Decode($row['addlcost']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $menuitemoptionList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `menuitemoption` ";
		$menuitemoptionList = Array();
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
			$sortBy = "menuitemoptionid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$menuitemoption = new $thisObjectName();
			$menuitemoption->menuitemoptionId = $row['menuitemoptionid'];
			$menuitemoption->menuitemId = $row['menuitemid'];
			$menuitemoption->name = $this->Unescape($row['name']);
			$menuitemoption->addlCost = $this->Unescape($row['addlcost']);
			$menuitemoptionList[] = $menuitemoption;
		}
		return $menuitemoptionList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $menuitemoptionId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
		if (!empty($this->menuitemoptionId))
		{
			$this->pog_query = "select `menuitemoptionid` from `menuitemoption` where `menuitemoptionid`=".$this->Quote($this->menuitemoptionId, $connection)." LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `menuitemoption` set 
			`menuitemid`=:menuitemId,
			`name`=:name,
			`addlcost`=:addlcost where `menuitemoptionid`=:menuitemoptionId";
		}
		else
		{
			$this->menuitemoptionId = "";
			$this->pog_query = "insert into `menuitemoption` (`menuitemid`,`name`,`addlcost`,`menuitemoptionid`) values (
			:menuitemId,
			:name,
			:addlcost,
			:menuitemoptionId)";
		}
		$this->pog_bind = array(
			':menuitemId' => intval($this->menuitemId),
			':name' => $this->Encode($this->name),
			':addlcost' => $this->Encode($this->addlCost),
			':menuitemoptionId' => intval($this->menuitemoptionId)
		);
		$insertId = Database::InsertOrUpdatePrepared($this->pog_query, $this->pog_bind, $connection);
		if ($this->menuitemoptionId == "")
		{
			$this->menuitemoptionId = $insertId;
		}
		return $this->menuitemoptionId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $menuitemoptionId
	*/
	function SaveNew()
	{
		$this->menuitemoptionId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `menuitemoption` where `menuitemoptionid`=".$this->Quote($this->menuitemoptionId, $connection);
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
			$this->pog_query = "delete from `menuitemoption` where ";
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
	* Associates the MenuItem object to this one
	* @return boolean
	*/
	function GetMenuitem()
	{
		$menuitem = new MenuItem();
		return $menuitem->Get($this->menuitemId);
	}
	
	
	/**
	* Associates the MenuItem object to this one
	* @return 
	*/
	function SetMenuitem(&$menuitem)
	{
		$this->menuitemId = $menuitem->menuitemId;
	}
}
?>