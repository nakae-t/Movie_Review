<!-- SD3D 仲江鳳星 -->
<?php
// DB接続情報
$pdo = new PDO(
    'mysql:host=mysql325.phy.lolipop.lan;dbname=LAA1554917-aso2301180;charset=utf8',
    'LAA1554917',
    'Pass0708'
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// アップロード先のディレクトリ
$uploadDir = 'img/';

// POST送信チェック
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addMovie'])) {

    // 入力値の取得
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];

    // 画像ファイル処理
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['photo']['tmp_name'];
        $originalName = basename($_FILES['photo']['name']);
        $saveName = uniqid() . '_' . $originalName;
        $savePath = $uploadDir . $saveName;

        // ディレクトリがなければ作成
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // ファイル移動
        if (move_uploaded_file($tmpName, $savePath)) {
            try {
                // SQL準備・実行
                $sql = "INSERT INTO movies (title, genre, director, photo_path) 
                        VALUES (:title, :genre, :director, :photo_path)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':title' => $title,
                    ':genre' => $genre,
                    ':director' => $director,
                    ':photo_path' => $savePath
                ]);

                echo "映画が追加されました。<a href='index.php'>戻る</a>";

            } catch (PDOException $e) {
                echo "データベースエラー: " . $e->getMessage();
            }
        } else {
            echo "画像のアップロードに失敗しました。<a href='index.php'>戻る</a>";
        }
    } else {
        echo "画像ファイルが正しく選択されていません。<a href='index.php'>戻る</a>";
    }
} else {
    echo "映画の追加に失敗しました。<a href='index.php'>戻る</a>";
}
?>
