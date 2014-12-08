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
		for ($i = 0; $i < 15; $i++) {
			foreach($html->find('li[id=result_'.$i.']') as $element) {
	       		echo $element . '<br>';
			}
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		}
	}
	?>

</body>

</html>
