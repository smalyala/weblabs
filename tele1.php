<!DOCTYPE html>

<html>

<head>
  	<title>Telelearn assignment</title>
</head>
 	<body>
 	<form name="f" method="GET" action="tele1.php">
 		Type string to permute:
 		<input type="text" name="myStr">
 			<button type="submit" accesskey="s"><u>S</u>ubmit</button>
 	</form>
 	 <?php 

 	 	// function to swap the char at pos $i and $j of $str.
		function swap(&$datum,$i,$j) {
		    $temp = $datum[$i];
		    $datum[$i] = $datum[$j];
		    $datum[$j] = $temp;
		} 

 		// function to generate and print all N! permutations of $str. (N = strlen($str)).
		function solve($datum,$i,$n) {
		   if ($i == $n)
		       echo "$datum\n";
		   else {
		        for ($j = $i; $j < $n; $j++) {
		          swap($datum,$i,$j);
		          solve($datum, $i+1, $n);
		          swap($datum,$i,$j); // backtrack.
		       }
		   }
		}
		$datum = $_REQUEST['myStr'];
		solve($datum, 0,strlen($datum)); // call the function.
	 	
	?> 
	</body>
</html>
