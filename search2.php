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
  <?php
  include('simple_html_dom.php');
  function get_html_content($url) {
      $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2';

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

      $string = curl_exec($ch);
      curl_close($ch);

      return $string;
  }
  error_reporting(0);
  $db = new SQLite3('amazon.db');
  $url = "http://www.amazon.com/s/ref=nb_sb_noss_2/182-8477515-7038932?url=search-alias%3Daps&field-keywords=table";
  $url = preg_replace("|\s|", "+", $url);
  $html = file_get_html($url);
  foreach($html->find('li[id=result_0]') as $element) {
    $image = $element->find('img', 0);
    $title = $element->find('a', 1);
  }
  echo "<center><h2><b>Product</b></h2></center>";
  echo "<center>".$image."</center>";
  $title = preg_replace('|<a.*><h2.*>(.*)</h2></a>|iU', '\1' , $title);
  echo "<center><h4>".$title."</h4></center>";
  $results = $db->query('SELECT * FROM amz');
  $tbl = "<table border='1' id='myTable' class='tablesorter'><thead><tr><th><b><h2><center>Price</center></h2></b></th><th><b><h2><center>Condition</center></h2></b></th>
  <td><b><h2><center>Seller</center></h2></b></td><td><b><h2><center>Logistics</center></h2></b></td></tr></thead><tbody>";
  while ($row = $results->fetchArray()) {
    $tbl .= "<tr><td><center>".$row[1]."</center></td><td><center>".$row[2]."</center></td><td><center>".$row[3]."</center></td><td><center>".$row[4]."</center></td></tr>";
  }
  $tbl .= "</tbody></table>";
  $tbl = preg_replace('|<a.*>(.*)</a>|iU', '\1' , $tbl);
  $tbl = preg_replace('|<form.*/form>|iU', '' , $tbl);
  $tbl = preg_replace('|Read\smore|iU', '' , $tbl);
  echo $tbl;
  ?> 

  <script>
  function sortT() {
    $("#myTable").tablesorter(); 
  }
  sortT();
  </script>

</body>

</html>
