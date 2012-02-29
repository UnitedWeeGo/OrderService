<?php
header ("Content-Type:text/xml");

require_once "reqbase.php";

class Orders extends ReqBase
{
	function Orders()
	{
		parent::__construct();
	}

	function process()
	{
		$lookup = new Instance();
		
		$instance = $lookup->Get($this->dataObj['instanceId']);
		$list = $instance->GetOrderList( array( array("orderId", ">", $this->dataObj['orderId'] ), array("completed", "=", 0 ) ) );
		
		$doc = new DOMDocument('1.0', 'UTF-8');
		$root = $doc->createElement('Orders');
		$doc->appendChild($root);
		
		for ($i=0; $i<count($list); $i++)
		{
			$order = $this->castOrder($list[$i]);
			$orderNode = $doc->createElement('Order');
			$root->appendChild($orderNode);
			$orderNode->setAttribute('orderId', $order->orderId);
			$orderNode->setAttribute('timestamp', $order->orderPlaced);
			
			$menuItems = $order->GetMenuitemList();
			for ($j=0; $j<count($menuItems); $j++)
			{
				$menuItem = $this->castMenuItem($menuItems[$j]);
				$menuItemNode = $doc->createElement('MenuItem');
				$orderNode->appendChild($menuItemNode);
				$menuItemNode->setAttribute('itemPrice', $menuItem->itemPrice);
				
				$menuItemNameNode = $doc->createElement('name');
				$menuItemNode->appendChild($menuItemNameNode);
				$name = $doc->createCDATASection($menuItem->name);
				$menuItemNameNode->appendChild($name);
				
				$menuItemCategoryFriendlyNameNode = $doc->createElement('categoryFriendlyName');
				$menuItemNode->appendChild($menuItemCategoryFriendlyNameNode);
				$categoryFriendlyName = $doc->createCDATASection($menuItem->categoryFriendlyName);
				$menuItemCategoryFriendlyNameNode->appendChild($categoryFriendlyName);
				
				$options = $menuItem->GetMenuitemoptionList();
				for ($k=0; $k<count($options); $k++)
				{
					$menuItemOption = $this->castMenuItemOption($options[$k]);
					$menuItemOptionNode = $doc->createElement('MenuItemOption');
					$menuItemNode->appendChild($menuItemOptionNode);
					$menuItemOptionNode->setAttribute('addlCost', $menuItemOption->addlCost);
					
					$menuItemOptionNameNode = $doc->createElement('name');
					$menuItemOptionNode->appendChild($menuItemOptionNameNode);
					$name = $doc->createCDATASection($menuItemOption->name);
					$menuItemOptionNameNode->appendChild($name);
				}
			}
			$customerList = $order->GetCustomerList();
			$customerObj = $this->castCustomer($customerList[0]);
			
			$customerNode = $doc->createElement('Customer');
			$orderNode->appendChild($customerNode);
			
			$customerNameNode = $doc->createElement('name');
			$customerNode->appendChild($customerNameNode);
			$name = $doc->createCDATASection($customerObj->name);
			$customerNameNode->appendChild($name);
		}
		echo $doc->saveXML();
	}
	
	/**
	* @param Order $order
	* @return Order
	*/
	function castOrder($order)
	{
		return $order;
	}
	
	/**
	* @param MenuItem $menuItem
	* @return MenuItem
	*/
	function castMenuItem($menuItem)
	{
		return $menuItem;
	}
	/**
	* @param MenuItemOption $menuItemOption
	* @return MenuItemOption
	*/
	function castMenuItemOption($menuItemOption)
	{
		return $menuItemOption;
	}
	/**
	* @param Customer $customer
	* @return Customer
	*/
	function castCustomer($customer)
	{
		return $customer;
	}
}

$consumer = new Orders();
$consumer->process();

?>