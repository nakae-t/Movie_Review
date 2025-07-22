<?php

$id = $_POST['delete_id'] ?? null;

// DB接続
$pdo = new PDO(
    "mysql:host=mysql325.phy.lolipop.lan;dbname=LAA1554917-aso2301180;charset=utf8",
    "LAA1554917",
    "Pass0708"
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if ($id !== null) {
    // 画像ファイルのパス取得
    $stmt = $pdo->prepare("SELECT photo_path FROM movies WHERE id = ?");
    $stmt->execute([$id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($movie && !empty($movie['photo_path']) && file_exists($movie['photo_path'])) {
        unlink($movie['photo_path']); // サーバーから画像削除
    }

    // 映画データ削除
    $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->execute([$id]);

    echo "映画を削除しました。<a href='index.php'>戻る</a>";

}else{
    echo "削除項目の取得に失敗しました。<a href='index.php'>戻る</a>";
}

exit;
?>

