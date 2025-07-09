<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>映画登録</h1>

    <form action="./addMovie.php" method="POST" enctype="multipart/form-data">
        <!-- 映画のタイトル -->
        <p>タイトル：<input type="text" name="title"></p>
        <!-- 映画のジャンル -->
        <p>ジャンル：<input type="text" name="genre"></p>
        <!-- 映画の監督 -->
        <p>監督：<input type="text" name="director"></p>
        <!-- 映画の画像 -->
        <p>画像：<input type="file" name="photo"></p>
        <!-- 送信ボタン_addMoveiに送信 -->
        <button type="submit" value="addMovei" name="addMovie">追加</button>

    </form>

    <hr>
    <h1>映画一覧</h1>

    <!-- 映画の一覧を表示 -->
    <?php
    try {
        // ロリポップ用の接続情報に変更
        $pdo = new PDO(
            "mysql:host=mysql325.phy.lolipop.lan;dbname=LAA1554917-aso2301180;charset=utf8",
            "LAA1554917",
            "Pass0708"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // データ取得
        $stmt = $pdo->query("SELECT * FROM movies ORDER BY id DESC");
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 表示処理
        foreach ($movies as $movie) {
            echo "<div>";
            echo "<h3>" . htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') . "</h3>";
            echo "<p>ジャンル: " . htmlspecialchars($movie['genre'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p>監督: " . htmlspecialchars($movie['director'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<img src='" . htmlspecialchars($movie['photo_path'], ENT_QUOTES, 'UTF-8') . "' alt='映画画像' width='200'>";
            echo "</div><hr>";
        }
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
    ?>


</body>
</html>