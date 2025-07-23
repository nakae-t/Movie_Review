<?php

$id = $_POST['review'] ?? null;

if ($id === null) {
    header('Location: index.php');
    exit;
}


try {
    $pdo = new PDO(
        "mysql:host=mysql325.phy.lolipop.lan;dbname=LAA1554917-aso2301180;charset=utf8",
        "LAA1554917",
        "Pass0708"
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 映画情報の取得
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
    $stmt->execute([$id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        echo "対象の映画が見つかりません。<a href='index.php'>戻る</a>";
        exit;
    }

    // レビュー取得
    $reviewStmt = $pdo->prepare("SELECT * FROM reviews WHERE movie_id = ?");
    $reviewStmt->execute([$id]);
    $reviews = $reviewStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "エラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>の詳細</title>
</head>
<body>

<h1><?= htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8') ?>の詳細</h1>
<hr>

<p><b>ジャンル：</b><?= htmlspecialchars($movie['genre'], ENT_QUOTES, 'UTF-8') ?></p>
<p><b>監督：</b><?= htmlspecialchars($movie['director'], ENT_QUOTES, 'UTF-8') ?></p>

<?php if (!empty($movie['photo_path']) && file_exists($movie['photo_path'])): ?>
    <img src="<?= htmlspecialchars($movie['photo_path'], ENT_QUOTES, 'UTF-8') ?>" alt="映画画像" width="450">
<?php else: ?>
    <p>画像はありません。</p>
<?php endif; ?>

<hr>

<h2>レビュー一覧</h2>

<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <p  style="background-color: #f0f0f0; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        <b><?=  htmlspecialchars($review['reviewer'], ENT_QUOTES, 'UTF-8')?>：</b> <?= nl2br(htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8')) ?></p>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>レビューはまだありません。</p>
    <hr>
<?php endif; ?>

<h2>レビューを追加</h2>

<form action="./addReview.php" method="POST">
    <input type="hidden" name="movie_id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
    <p>名前：<input type="text" name="reviewer" required></p>
    <p>コメント：<br><textarea name="comment" required></textarea></p>
    <button type="submit">追加</button>
</form>

<hr>
<a href="./index.php">← 映画一覧に戻る</a>

</body>
</html>
