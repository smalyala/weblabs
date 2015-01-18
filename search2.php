<!DOCTYPE html>
<html>
<head>
<title>Amazon Search</title>
<style>

td {
	width: 25%;
}

</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="jquery-latest.js"></script> 
<script type="text/javascript" src="jquery.tablesorter.js"></script> 

</head>

<body>

	<form name="f" method="POST" action="search2.php">
	<font color="orange"><b>Search Amazon:</b></font>
	<input type="text" id="myTextId" name="search">
		<button type="submit" accesskey="s"><u>S</u>earch</button>
	</form>

	<?php
	include('simple_html_dom.php');
	function get_html_content($url) {
	    // fake user agent
	    $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2';

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    //curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    //curl_setopt($ch,CURLOPT_COOKIEFILE,'cookies.txt');
	    //curl_setopt($ch,CURLOPT_COOKIEJAR,'cookies.txt');

	    $string = curl_exec($ch);
	    curl_close($ch);

	    return $string;
	}

	if (isset($_POST["search"])) {
    $db = new SQLite3('amazon.db');
		$search = $_POST["search"];
		$url = "http://www.amazon.com/s/ref=nb_sb_noss_2/182-8477515-7038932?url=search-alias%3Daps&field-keywords=".$search;
    $url = preg_replace("|\s|", "+", $url);
		$html = file_get_html($url);
		foreach($html->find('li[id=result_0]') as $element) {
     		$prod_url = $element->find('a', 0)-> href;
     		$image = $element->find('img', 0);
     		$title = $element->find('a', 1);
     		$id = explode("dp/", $prod_url);
     		$id = explode("/", $id[1]);
     		$id = $id[0];
   	}
   	echo "<center><h2><b>Product</b></h2></center>";
   	echo "<center>".$image."</center>";
   	$title = preg_replace('|<a.*><h2.*>(.*)</h2></a>|iU', '\1' , $title);
   	echo "<center><h4>".$title."</h4></center>";
	    $url2 = "http://www.amazon.com/gp/offer-listing/".$id;
 		$html2 = get_html_content($url2);
 		$html2 = str_get_html($html2);
 		$count = 0;
 		foreach($html2->find('div[class=olpOffer]') as $element) {
 			if ($count < 10) {
 				$count2 = 0;
        $arr = [];
 				foreach($element->find('div[class=a-column]') as $each) {
 					if ($count2 < 4) {
 						if ($count2 == 1) {
 							$comp = "";
 							foreach($each->find('h3[class=olpCondition]') as $texts) {
   							$comp .= $texts;
   						}
              $each = preg_replace('|<span.*/span>|iU', '' , $comp);
 						}
            array_push($arr, $each);
 						$count2 += 1;
 					}
 				}
        $tid = "c".hash('sha256', $arr[0]).rand(2, 100).rand(101, 1000);
        $insert = "INSERT INTO amz (id, price, condition, seller, logistics) VALUES ('".$tid."','".$arr[0]."','".$arr[1]."','".$arr[2]."','".$arr[3]."')";
        //$insert = str_replace('?', '', $insert);
        //$insert = str_replace('shippingMessage_ftinfo_olp_.', '', $insert);
        //print $insert;
        $db->exec($insert);
 				$count += 1;
 			}
 		}
    $results = $db->query('SELECT * FROM amz');
    $tbl = "<table border='1' id='myTable' class='tablesorter'><thead><tr><th><b><h2><center>Price</center></h2></b></th><th><b><h2><center>Condition</center></h2></b></th>
      <td><b><h2><center>Seller</center></h2></b></td><td><b><h2><center>Logistics</center></h2></b></td></tr></thead><tbody>";
    while ($row = $results->fetchArray()) {
      $tbl .= "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td></tr>";
    }
 		$tbl .= "</tbody></table>";
    $tbl = preg_replace('|<a.*>(.*)</a>|iU', '\1' , $tbl);
    $tbl = preg_replace('|<form.*/form>|iU', '' , $tbl);
    $tbl = preg_replace('|Read\smore|iU', '' , $tbl);
		echo $tbl;
	}
	?> 
	<script>
		document.getElementById('myTextId').focus();
	  function sortT() {
      $("#myTable").tablesorter(); 
    }
    sortT();
	</script>

</body>

</html>
