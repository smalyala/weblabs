<!DOCTYPE html>
<html>
<head>
<title>Visitors</title>
</head>
<body>

<b>Strange how you found this page. Below are data on this page's last visits.</b>
<br>
<br>

<?php  

$arr = file('visits.txt');
echo "Last visit: " . end($arr);
file_put_contents("visits.txt", "");

$file = 'visits.txt';
$current = file_get_contents($file);
$current .= date("g:i:s");
echo "<br> Current time: " . date("g:i:s");
file_put_contents($file, $current);

$handle = fopen("counter.txt", "r"); 
if(!$handle) { 
	echo "could not open the file"; 
} 
else { 
	$counter = (int ) fread($handle,20); 
	fclose ($handle); $counter++; 
	echo" <br> You are the ". $counter . "th visitor" ; 
	$handle = fopen("counter.txt", "w" ); 
	fwrite($handle,$counter) ; 
	fclose ($handle) ;
}

?>
<br>

</body>
</html>
