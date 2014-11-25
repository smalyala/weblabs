<!DOCTYPE html>

<html>

<head>
  <title>Telelearn assignment</title>
</head>
 	<body>
 	<?php $datum = $_REQUEST['myStr'];
 		echo $datum;
 	?> 
 	<form name="f" method="GET" action="tele.php">
 		Type string to permute:
 		<input type="text" name="myStr">
 			<button type="submit" accesskey="s"><u>S</u>ubmit</button>
 	</form>
	</body>
</html>
