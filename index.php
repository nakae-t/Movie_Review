<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>映画詳細画面</title>
</head>
<body>
    <h1>映画登録</h1>

    <form action="./addMovie.php" method="POST" enctype="multipart/form-data">
        <!-- 映画のタイトル -->
        <p>タイトル：<input type="text" name="title" required></p>
        <!-- 映画のジャンル -->
        <p>ジャンル：<input type="text" name="genre" required></p>
        <!-- 映画の監督 -->
        <p>監督：<input type="text" name="director" required></p>
        <!-- 映画の画像 -->
        <p>画像：<input type="file" name="photo" required></p>
        <!-- 送信ボタン_addMoveiに送信 -->
        <button type="submit" value="addMovie" name="addMovie">追加</button>

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
        
    ?>

    <table border="1" style="text-align: center; width: 1000px;">
        <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>ジャンル</th>
            <th>監督</th>
            <th>画像</th>
            <th>アクション</th>
        </tr>
        <?php foreach ($movies as $movie): ?>
        <tr>
            <td><?= htmlspecialchars($movie['id']) ?></td>
            <td><?= htmlspecialchars($movie['title']) ?></td>
            <td><?= htmlspecialchars($movie['genre']) ?></td>
            <td><?= htmlspecialchars($movie['director']) ?></td>
            <td>
                <?php if ($movie['photo_path']): ?>
                    <img src="<?= htmlspecialchars($movie['photo_path']) ?>" width="200">
                <?php else: ?>
                    画像なし
                <?php endif; ?>
            </td>
           <td>
                <form action="./detailMovie.php" method="POST" style="display:inline;">
                    <input type="hidden" name="review" value="<?= $movie['id'] ?>">
                    <button type="submit">編集</button>
                </form>

                <form action="./deleteMovie.php" method="POST" style="display:inline;" onsubmit="return confirm('削除しますか？');">
                    <input type="hidden" name="delete_id" value="<?= $movie['id'] ?>">
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
        
        
    <?php 
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
    ?>
    


</body>
</html>