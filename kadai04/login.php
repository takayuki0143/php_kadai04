<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/main.css" />
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
        .non-log{
            margin-top: 30px;
        }
    </style>
    <title>ログイン</title>
</head>

<body>

    <header>
        <nav class="navbar navbar-default">ログインページ</nav>
    </header>
    
    <!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
    <p></p>
    <form name="form1" action="login_act.php" method="post">
        ID：<input type="text" name="lid" />
        PW：<input type="password" name="lpw" />
        <input type="submit" value="LOGIN" />
    </form>
    <div class="non-log">
    <!-- ☆下記はログインしたくない場合でも使用可能です。<br>
    ログインをするとデータの削除と編集が可能になります。 -->
    </div>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <!-- <a class="navbar-brand" href="index.php">データ登録</a>
                    <a class="navbar-brand" href="nonlog_select.php">データ一覧</a> -->
                </div>
            </div>
        </nav>
    </header>


</body>

</html>
