<?php if (!(php_sapi_name() == "cli")) : ?>
<!DOCTYPE html>

<html>

<head>
  	<title>Telelearn assignment</title>
</head>
 	<body>
 	<form name="f" method="GET" action="tele.php">
 		Type string to permute:
 		<input type="text" name="myStr">
 			<button type="submit" accesskey="s"><u>S</u>ubmit</button>
 	</form>
<?php endif; ?>

 	<?php 

		function swap(&$datum,$i,$j) {
		    $temp = $datum[$i];
		    $datum[$i] = $datum[$j];
		    $datum[$j] = $temp;
		} 

		function solve($datum,$i,$n) {
		   if ($i == $n) {
		   		global $arr;
		   		if (!in_array($datum, $arr)) {
		    		array_push($arr, $datum);
		    	}
		    }
		   else {
		        for ($j = $i; $j < $n; $j++) {
		          swap($datum,$i,$j);
		          solve($datum, $i+1, $n);
		          swap($datum,$i,$j); 
		       }
		   }
		}
		$arr = [];
		if (php_sapi_name() == "cli") {
			if (isset($argv[1])) {
				$datum = $argv[1];
				solve($datum, 0,strlen($datum));
				echo 'Permutations: '. count($arr)."\n";
				print_r($arr);
			} 
		} 
		else {
		    $datum = $_REQUEST['myStr'];
			solve($datum, 0,strlen($datum)); 
			echo 'Permutations: '. count($arr);
			echo '<pre>'; 
			print_r($arr); 
			echo '</pre>';	
		}
	?> 
	
<?php if (!(php_sapi_name() == "cli")) : ?>
	</body>
</html>
<?php endif; ?>