<!DOCTYPE html>
<html>

<body>

	<form name="f" method="POST" action="search.php">
	Search Amazon:
	<input type="text" name="search">
		<button type="submit" accesskey="s"><u>S</u>earch</button>
	</form>

	<?php
	include('simple_html_dom.php');
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
   	    $url2 = "http://www.amazon.com/gp/offer-listing/".$id;
   		$html2 = file_get_html($url2);
   		echo $html2;

		// $j = 0;
		// $arr = [];
		// $tbl = "<table>";
		// for ($i = 0; $i < 14; $i++) {
		// 	if (($j-1) % 3 == 0) {
		// 		$arr = [];
		// 	}
		// 	foreach($html->find('li[id=result_'.$i.']') as $element) {
	 //       		array_push($arr, $element);
		// 	}
		// 	if ($j % 3 == 0) {
		// 		$tbl .= "<tr><td>" . $arr[0] . "</td><td>" . $arr[1] . "</td><td>" . $arr[2] . "</td></tr>";
		// 	}
		// 	$j++;
		// }
		// $tbl .= "</table>";
		// echo $tbl;
	}
	?>

</body>

</html>
