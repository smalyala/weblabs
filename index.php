<!DOCTYPE html>
<html>
<head>
<title>Previous Visit</title>
<script>
setInterval(function() {
    var currentTime = new Date ( );    
    var currentHours = currentTime.getHours ( );   
    var currentMinutes = currentTime.getMinutes ( );   
    var currentSeconds = currentTime.getSeconds ( );
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;   
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;    
    var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";    
    currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;    
    currentHours = ( currentHours == 0 ) ? 12 : currentHours;    
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    document.getElementById("timer").innerHTML = currentTimeString;
}, 1000);
</script>
</head>
<body>

<?php  

$arr = file('visits.txt');
echo "Last visit at " . end($arr);

$file = 'visits.txt';
$current = file_get_contents($file);
$current .= date("g:i:s");
echo "<br> Current time " . date("g:i:s");
file_put_contents($file, $current);

$handle = fopen("counter.txt", "r"); 
if(!$handle) { 
	echo "could not open the file"; 
} 
else { 
	$counter = (int ) fread($handle,20); 
	fclose ($handle); $counter++; 
	echo" <br> <strong> You are the ". $counter . " visitor </strong> " ; 
	$handle = fopen("counter.txt", "w" ); 
	fwrite($handle,$counter) ; 
	fclose ($handle) ;
}

?>
<br>
Current time:
<div id="timer"></div>

</body>
</html>
