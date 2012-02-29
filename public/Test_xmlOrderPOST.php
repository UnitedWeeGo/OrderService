<?php 

$xml = <<<EOF
<?xml version="1.0"?>
<Order instanceId="26">
	<MenuItem itemPrice="3.30">
		<name><![CDATA[Royal with Cheese]]></name>
		<MenuItemOption addlCost="0">
			<name><![CDATA[Lettuce]]></name>
		</MenuItemOption>
		<MenuItemOption addlCost="0">
			<name><![CDATA[Tomato]]></name>
		</MenuItemOption>
		<MenuItemOption addlCost="1.05">
			<name><![CDATA[Extra Cheese]]></name>
		</MenuItemOption>
		<MenuItemOption addlCost="1.40">
			<name><![CDATA[Bacon]]></name>
		</MenuItemOption>
	</MenuItem>
	<Customer>
		<name><![CDATA[Nick Velloff]]></name>
		<title><![CDATA[Designer]]></title>
		<email><![CDATA[nick@velloff.com]]></email>
		<phoneNumber><![CDATA[+18015564968]]></phoneNumber>
	</Customer>
</Order>
EOF;

?>
<html>
<head>
<title>Personal INFO</title>
</head>
<body>
	<form method="post" action="placeorder.php">
		<textarea rows="35" cols="100" name="xmlData" wrap="soft"><?php echo $xml; ?></textarea>
		<br /><input TYPE=submit NAME=go VALUE="post to script">
	</form>
</body>
</html>