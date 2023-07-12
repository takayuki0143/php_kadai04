<?php

// 0. SESSION開始！！
session_start();

//１．関数群の読み込み
require_once('funcs.php');
loginCheck();

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=kadai_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError'.$e->getMessage());
}

//２．データ取得SQL作成

// 検索ワードの受け渡し
$search = $_POST['search'];

// 現在は全て取得しているので、(SELECT以後を変えれば、)入力ワード検索とかもできるのかもしれない?
$stmt = $pdo->prepare("SELECT * FROM kadai_an_table WHERE tag LIKE '%{$search}%'");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    // データの整形をしたい

    $date .= "<p>";
    $date .= h($result['date']); 
    $date .= "</p>";

    $tag .= "<p>";
    $tag .= h($result['tag']); 
    $tag .= "</p>";

    // idに紐づいて詳細ページにリンクを飛ばす
    $content .= "<p>";
    $content .= '<a href="detail.php?id=' . $result['id'] . '">';
    $content .= h($result['content']); 
    $content .= '</a>';
    $content .= "</p>";
    
    $url .= "<p>";
    $url .= '<a href="' . h($result['url']) . '">' . h($result['url']) .'</a>';  
    $url .= "</p>";
    
    $memo .= "<p>";
    $memo .= h($result['memo']); 
    $memo .= "</p>";

    $delete .= "<p>";
    $delete .= '<a href="delete.php?id=' . $result['id'] . '">';
    $delete .= "削除"; 
    $delete .= '</a>';
    $delete .= "</p>";

  }

}
  // JSにデータを渡す
  $json_content = json_encode($content);


// ☆セレクトボックスで選択された内容を取得
$selectedValue = $_GET['select'];

// SQL文の準備と実行
$stmt = $pdo->prepare("SELECT url FROM kadai_an_table WHERE content = :selected_value");
$stmt->bindValue(':selected_value', $selectedValue, PDO::PARAM_STR);
$stmt->execute();

// 結果の取得
$select = $stmt->fetchColumn();


   // データの整形をしたい
   $selection .= h($select); 
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>登録一覧</title>
<link rel="stylesheet" href="css/range.css">
<style>div{padding: 10px;font-size:16px;}
 .sharing{
  margin-left: 320px;
 }
 .share{
  display: flex;
 }

</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      登録一覧
      <input type=button onclick= "location.href='index.php'" value="登録に戻る">
      <input type=button onclick= "location.href='first.php'" value="ホームに戻る">
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container">
    <table class="table">
      <tr>
        <th>日付</th>
        <th>タグ</th>
        <th>内容</th>
        <th>URL</th>
        <th>MEMO</th>
        <th>削除</th>
      </tr>
      <tr>
        <td><?= $date ?></td>
        <td><?= $tag ?></td>
        <td><?= $content ?></td>
        <td><?= $url ?></td>
        <td><?= $memo ?></td>
        <td><?= $delete ?></td>
      </tr>
    </table>
    </div>

</div>
<div class="sharing">
  共有用：
<div class="share">

  <div class="share-left">
    <form action="select.php" method="get">
    <select id="mySelect" name="select">
    <option>---選択してください---</option>
    <?php
    // 追加された内容をオプションに追加
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $optionContent = h($result['content']);
      echo "<option value='$optionContent'>$optionContent</option>";
    }
    ?>
    </select>
    <button type="submit" id="relate">URLを出力する</button>
  </div>
    </form>

  <div class="share-right">
    <input type="text" id="share" value="<?= $selection ?>">
    <button id="tweet">共有する</button>
  </div>

<!-- Main[End] -->
</div>


</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
  //URLをツイートできるようにしたい
$("#tweet").on("click",function(){
    const share = $("#share").val();
    const tweet ="https://twitter.com/intent/tweet?text="+encodeURIComponent(`共有するよ!!：${share}`)+'&hashtags=ジーズ共有';
    window.open(tweet);
})

//追加された内容をオプションに追加したい
const select = document.getElementById("mySelect");
  const elements = '<?php echo $content; ?>'; // PHPで出力された内容をJSに渡す

  const elementArray = elements.split('</p><p>'); // 各要素を分割して配列にする
  for (let i = 0; i < elementArray.length; i++) {
    const element = elementArray[i];
    const option = document.createElement("option");
    option.text = element.replace(/<\/?a[^>]*>/g, '').replace('<p>', '').replace('</p>', ''); // <p>タグ,<a>タグを除去
    option.value = option.text;
    select.appendChild(option);
  }

</script>
