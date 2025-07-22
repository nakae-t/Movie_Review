<?php
// POSTデータの受け取り
$movie_id = $_POST['movie_id'] ?? null;
$reviewer = $_POST['reviewer'] ?? '';
$comment = $_POST['comment'] ?? '';



try {
    // DB接続
    $pdo = new PDO(
        "mysql:host=mysql325.phy.lolipop.lan;dbname=LAA1554917-aso2301180;charset=utf8",
        "LAA1554917",
        "Pass0708"
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データ挿入
    $stmt = $pdo->prepare("INSERT INTO reviews (movie_id, reviewer, comment) VALUES (?, ?, ?)");
    $stmt->execute([$movie_id, $reviewer, $comment]);

    // 詳細画面に戻る
    header("Location: detailMovie.php");
    exit;

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    exit;
}
?>
