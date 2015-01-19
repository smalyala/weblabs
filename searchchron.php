<!DOCTYPE html>
<html>
<head>
<title>Amazon Search</title>
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

  if (isset($_POST["search"])) {
    error_reporting(0);
    $db = new SQLite3('amazon.db');
    $url = "http://www.amazon.com/s/ref=nb_sb_noss_2/182-8477515-7038932?url=search-alias%3Daps&field-keywords=table";
    $url = preg_replace("|\s|", "+", $url);
    $html = file_get_html($url);
    foreach($html->find('li[id=result_0]') as $element) {
        $prod_url = $element->find('a', 0)-> href;
        $id = explode("dp/", $prod_url);
        $id = explode("/", $id[1]);
        $id = $id[0];
    }
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
        $db->exec($insert);
        $count += 1;
      }
    }
  }
  ?> 

</body>

</html>
