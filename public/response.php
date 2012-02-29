<?php

class Response 
{
	const ResultSuccess = '200';
	
	function Response()
	{
		//
	}
	
	function getResult($SuccessConst, $id=null)
	{
		$doc = new DOMDocument('1.0', 'UTF-8');
		$root = $doc->createElement('response');
		$doc->appendChild($root);
		$root->setAttribute('result', $SuccessConst);
		
		if ($id)
		{
			$root->setAttribute('id', $id);
		}
		
		return $doc->saveXML();
	}
}

?>