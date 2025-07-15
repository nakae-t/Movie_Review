<?php

$id = $_POST['id'] ?? null;

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

