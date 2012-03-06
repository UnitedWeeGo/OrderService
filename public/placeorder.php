<?php

require_once "reqbase.php";

header ("Content-Type:text/xml");
//header ("Content-Type:text/plain");

class PlaceOrder extends ReqBase
{
	function PlaceOrder()
	{
		parent::__construct();
	}
	
	function process()
	{
		
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->loadXML($xml);
		
		$orderNode = $doc->getElementsByTagName( "Order" ) -> item(0);
		$instanceId = $orderNode->getAttribute('instanceId');
		
		$lookupObj = new Instance();
		$instanceObj = $lookupObj->Get($instanceId);
		
		$orderObj = new Order();
		$orderObj->orderPlaced = $this->getTimeStamp();
		
		// populate the Order with each Customer
		$orderCustomerList = $orderNode->getElementsByTagName( "Customer" );
		$orderCustomerListLength = $orderCustomerList->length;
		for ($c=0; $c<$orderCustomerListLength; $c++)
		{
			$customerNode = $orderCustomerList->item($c);
			$nodeObj = array();
			$this->populateObjectFromXML($customerNode, $nodeObj);
			
			$customerObj = new Customer();
			$props = array('name','phoneNumber','title','email');
			$this->populateObject($props, $nodeObj, $customerObj);
			
			$orderObj->AddCustomer($customerObj);
		}
		
		// populate the Order with each MenuItem
		$menuItemsList = $orderNode->getElementsByTagName( "MenuItem" );
		$menuItemsListLength = $menuItemsList->length;
		
		//if there are no menu items, automatically mark order as completed
		if($menuItemsListLength <= 0)
		{
			$orderObj->orderCompletedTime = $orderObj->orderPlaced;
			$orderObj->completed = 1;
		}
		
		for ($a=0; $a<$menuItemsListLength; $a++)
		{
			$menuItemNode = $menuItemsList->item($a);
			$nodeObj = array();
			$this->populateObjectFromXML($menuItemNode, $nodeObj);
			
			$menuItemObj = new MenuItem();
			$props = array('itemPrice','name','categoryFriendlyName');
			$this->populateObject($props, $nodeObj, $menuItemObj);
			
			// populate the MenuItem with each MenuItemOption
			$menuItemsOptionList = $menuItemNode->getElementsByTagName( "MenuItemOption" );
			$menuItemsOptionListLength = $menuItemsOptionList->length;
			for ($b=0; $b<$menuItemsOptionListLength; $b++)
			{
				$menuItemOptionNode = $menuItemsOptionList->item($b);
				$nodeObj = array();
				$this->populateObjectFromXML($menuItemOptionNode, $nodeObj);
				
				$menuItemOptionObj = new MenuItemOption();
				$props = array('addlCost','name');
				$this->populateObject($props, $nodeObj, $menuItemOptionObj);
				
				$menuItemObj->AddMenuitemoption($menuItemOptionObj);
				
			}
			
			$orderObj->AddMenuitem($menuItemObj);
		}
		
		$instanceObj->AddOrder($orderObj);

		$instanceObj->Save(true);
		
		$response = new Response();
		echo $response->getResult(Response::ResultSuccess);
	}

	
	/**
	* Populate an object with xml data
	* @param DOMElement $node
	* @param Object $object
	* @return Object
	*/
	function populateObjectFromXML(&$node, &$object)
	{
	    if ($node->hasAttributes())
	    {
	        foreach ($node->attributes as $attr)
	        {
	            $object[$attr->nodeName] = $attr->nodeValue;
	        }
	    }

	    foreach ($node->childNodes as $childNode)
        {
			if ($childNode->nodeType != XML_TEXT_NODE)
            { 
            	$object[$childNode->nodeName] = $childNode->nodeValue;
            } 
        }
    
	    return $object; 
	}
	
	/**
	* Populates an object with properties from a source object using an array of prop names
	* @param Array $props
	* @param Array $srcObject
	* @param Object $trgObject
	*/
	function populateObject(&$props,&$srcObject,&$trgObject)
	{
		$didChange = false;
		for ($i=0; $i<count($props); $i++)
		{
			$prop = $props[$i];
			if ( isset($srcObject[$prop]) )
			{
				$trgObject->$prop = $srcObject[$prop];
				$didChange = true;
			}
		}
		return $didChange;
//		print_r($trgObject);
	}
}

$consumer = new PlaceOrder();
$consumer->process();

?>