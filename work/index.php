<!DOCTYPE html>
  <html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>WORKSPACE EXPLODER</title>
    <link rel="shortcut icon" href="http://192.168.11.4/work.git/work/Images/cafe_icon2.ico" type="image/vnd.microsoft.icon" />

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>

    <body class='background'>
    <div class="container mx-auto">
     <header>
    <h1>作業できる店を探す</h1>
    </header>

    <section>
    <form name="form1" id="id_form1" action = "index.php" method = "post" >
     wifi: <select name="wifi" class='pt-1 pb-1 pl-1 pr-1 mr-3'>
        <option value="1">あり</option>
        <option value="0">なし</option>
      </select>
      電源: <select name="outret" class='pt-1 pb-1 pl-1 pr-1'>
        <option value="1">あり</option>
        <option value="0">なし</option>
      </select><br>

      <input name="address" id="input02" type="text" size="16" value="" placeholder="例:新宿,渋谷" class='mt-3 mb-2 ml-1 mr-1'><br>
      <!-- <input id="button" value="決定" type="submit" class="btn btn-success">       -->
      <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> 決定 </button>
    </form>

<!-- <script type="php" src="js/main.js"></script> -->

    <?php
          $address = null;
      if(isset($_POST['address'])){
      $base_url = 'https://api.gnavi.co.jp/RestSearchAPI/v3/';
      $key = '9449b9d109b9b2cf8c3fcba23823e9a7';
      $wifi = $_POST['wifi'];
      $outret = $_POST['outret'];
      $address = $_POST['address'];
      $number = 100;
      $category = "RSFST18001,RSFST18002";
      $response = @file_get_contents( $base_url . "?keyid=" . $key ."&category_s=" . $category . "&address=" . $address . "&hit_per_page=" . $number . "&wifi=" . $wifi . "&outret=" . $outret);

      //var_dump($response);

  // jsonデコード
  $response_json = json_decode($response);
  echo "<h3 class='mt-5 mb-4 ml-3 mr-3'>一覧</h3>";
  //var_dump($response_json);

  // こんな風に取り出せる
  //echo "件数:" . $response_json->total_hit_count;
  $count = 0;
  if($address != null){
foreach($response_json->rest as $gurunavi){
    if($gurunavi->budget < 2000){
  echo "<h3 class='mt-5'>" . $gurunavi->name . "</h3>";
  // echo '<div class="container mx-auto mt-3 mb-3 ml-3 mr-3"><form name="form2" id="id_form2" action = "index.php" method = "post"><input id="button2" value="お気に入りに登録!" type="submit" class="btn btn-warning"></form></div>';
  echo "<div class='row'>";
  echo "<div class='col-sm-4'>";
  if($gurunavi->image_url->shop_image1 == "") {
      echo "<img src='Images/テイクアウトのコーヒーのアイコン2.png' width='260' height='226' alt='喫茶店画像'><br>";
  }
  else {
      echo "<div class='text-center'><img src = '" .$gurunavi->image_url->shop_image1 . "' alt='喫茶店画像' class='img-responsive'><br></div>";
  }
  echo "<br>";
  echo "</div>";
  // echo "<div class='text-center'><img src = '" .$gurunavi->image_url->qrcode . "' alt='喫茶店画像' class='img-responsive'><br></div>";
  echo "<div class='col-sm-6'>";
  echo "<h4>-" . $gurunavi->pr->pr_short . "-</h4>";
  echo "</div>";
  echo "</div>";


  echo "<table height='200' class='table table-bordered table table-dark mb-5'>";
  echo "<tbody>";
  echo "<tr><th  class='align-middle text-center'>電話番号</th><td>" .
  $gurunavi->tel . "</td></tr>";
  echo "<tr><th  class='align-middle text-center'>住所</th><td>" .
  $gurunavi->address . "</td></tr>";
  if($gurunavi->access->line == "") {
      echo "<tr><th  class='align-middle text-center'>アクセス</th><td></td></tr>";
  }
  else {
      echo "<tr><th  class='align-middle text-center'>アクセス</th><td>" .
  $gurunavi->access->line . $gurunavi->access->station .
  $gurunavi->access->station_exit . "から" . $gurunavi->access->walk . "分"
  . "</td></tr>";
  }
  $str = nl2br($gurunavi->opentime);
  echo "<tr><th class='align-middle text-center'>営業時間</th><td>" .
  $str . "</td></tr>";
  echo "<tr><th  class='align-middle text-center'>休業日</th><td>" .
  $gurunavi->holiday . "</td></tr>";
  if($gurunavi->budget =="") {
      echo "<tr><th  class='align-middle text-center'>平均予算</th><td></td></tr>";
  }
  else {
      echo "<tr><th  class='align-middle text-center'>平均予算</th><td>" .
  $gurunavi->budget . "円</td></tr>";
  }
  echo "</tbody>";
  echo "</table><br><br><br><br>";
  $count++;
  }
      }
    }else{
    echo "<h3 class='mt-5 mb-4 ml-3 mr-3'>エラーです。</h3>";
    }
}
if($address == null){
    print '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>';
    print '<script type="text/javascript" src="js/jquery.cookie.js"></script>';
    print '<script type="text/javascript" src="js/main.js"></script>';
        }
?>

</section>
<footer>
<?php
if($address != null){
echo "<h3 class='mt-5 mb-5 ml-3 mr-3'>検索結果は以上" . $count . "件です。</h3>";
}
?>
<br><br><br><br>;
</footer>
</div>
</body>
</html>
