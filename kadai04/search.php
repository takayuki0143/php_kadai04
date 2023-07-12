
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
    <header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
        <!-- <a class="navbar-brand" href="index.php">データ登録に戻る</a> -->
        </div>
        </div>
    </nav>
    </header>

    <form action="select.php" method="post">
    <label>タグ検索：
    <select name="search">
    <option>---選択してください---</option>
                    <option>開発</option>
                    <option>Twitter</option>
                    <option>仕事</option>
                    <option>備忘録</option>
                    <option>趣味</option>
        </select>
    </label>
    <input type="submit" value="検索する">
    </form>
</body>
</html>