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

			$lookup = new Customer();
			$customers = $lookup->GetList(array( array("orderid", "=", $order->orderId)));

			if($customers && sizeof($customers) > 0)
			{
				$customer = $customers[0];
				$service = $GLOBALS['configuration']['celltrust_service'];
			
				//initialize the request variable
				$request = "";
			
				$param["SMSDestination"] = $this->processPhoneNumber($customer->phoneNumber);
			
				$param["Username"] = $GLOBALS['configuration']['celltrust_user'];
				$param["Password"] = $GLOBALS['configuration']['celltrust_password'];
			
				$param["CustomerNickname"] = $GLOBALS['configuration']['celltrust_keyword']; 
				$param["Message"] = "Your FREE SUB is ready! Head to the Short Bus pickup window. And be sure to party with us Sunday night! ow.ly/9q1Iq";
			
				foreach($param as $key=>$val){
					$request.= $key."=".urlencode($val);
					$request.= "&";
				}
				//remove the final ampersand sign from the request
				$request = substr($request, 0, strlen($request)-1); 
			
				//send request
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $service); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POST, 1); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $request); 
				$response = curl_exec($ch); 
				curl_close($ch);  		
				
				$response = new Response();
				echo $response->getResult(Response::ResultSuccess, $order->orderId);
			}
		}
	}
	
	function processPhoneNumber($number)
	{
		$pattern = '/[\D]/';
		$number = preg_replace($pattern,'', $number);
		if(strlen($number) <= 10)
		{
			$number = "1".$number;
		}
		return $number;
	}
}

$consumer = new OrderComplete();
$consumer->process();

?>