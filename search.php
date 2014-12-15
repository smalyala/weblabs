<!DOCTYPE html>
<html>
<head>
<style>

td {
	width: 25%;
}

</style>
</head>

<body>

	<form name="f" method="POST" action="search.php">
	Search Amazon:
	<input type="text" name="search">
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
		$search = $_POST["search"];
		$url = "http://www.amazon.com/s/ref=nb_sb_noss_2/182-8477515-7038932?url=search-alias%3Daps&field-keywords=".$search;
		$html = file_get_html($url);
		foreach($html->find('li[id=result_0]') as $element) {
       		$prod_url = $element->find('a', 0)-> href;
       		$id = explode("dp/", $prod_url);
       		$id = explode("/", $id[1]);
       		$id = $id[0];
       		echo $id;
       	}
   	    $url2 = "http://www.amazon.com/gp/offer-listing/".$id."/ref=olp_tab_new?ie=UTF8&condition=new";
   		$html2 = get_html_content($url2);
   		$html2 = str_get_html($html2);
   		//echo $html2;
   		$count = 0;
   		$html3 = "";
   		$tbl = "<table border='1'><tr><td><b><h2><center>Price</center></h2></b></td><td><b><h2><center>Condition</center></h2></b></td>
   		<td><b><h2><center>Seller</center></h2></b></td><td><b><h2><center>Logistics</center></h2></b></td>";
   		foreach($html2->find('div[class=olpOffer]') as $element) {
   			if ($count < 10) {
   				$tbl .= "<tr>";
   				$count = 0;
   				foreach($element->find('div[class=a-column]') as $each) {
   					if ($count < 4) {
   						$tbl .= "<td><center>" . $each . "</center></td>";
   						$count += 1;
   					}
   				}
   				$tbl .= "</tr>";
   				$count += 1;
   			}
   		}
   		$tbl .= "</table>";
   		$tbl = preg_replace('|<a.*>(.*)</a>|iU', '\1' , $tbl);
		echo $tbl;
	}
	?>

</body>

</html>
