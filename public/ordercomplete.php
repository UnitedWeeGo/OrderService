<?php

header ("Content-Type:text/xml");

require_once "reqbase.php";

class OrderComplete extends ReqBase
{
	function OrderComplete()
	{
		parent::__construct();
	}
	
	function process()
	{
		$lookup = new Order();
		$order = $lookup->Get($this->dataObj['orderId']);
		
		if ($order)
		{
			$order->completed = 1;
			$order->orderCompletedTime = $this->getTimeStamp();
			$order->Save();
			
			/**
				HERE IS WHERE TO SEND THE SMS, PREFERABLY ASYNC
			 */
			
			
			$response = new Response();
			echo $response->getResult(Response::ResultSuccess, $order->orderId);
		}
	}
}

$consumer = new OrderComplete();
$consumer->process();

?>