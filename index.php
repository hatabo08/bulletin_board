<?php
//データベース接続
$pdo = new PDO('mysql:host=127.0.0.1;port=8889;dbname=bulletin_board;charset=utf8','root','root');

//投稿削除機能
if(isset($_GET['delete'])){
  $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
  $stmt->execute([$_GET['delete']]);
  header('Location: index.php');
  exit;
}

//投稿作成処理
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $stmt = $pdo->prepare('INSERT INTO posts (title, category, details) VALUES(?,?,?)');
  $stmt->execute([$_POST['title'],$_POST['category'],$_POST['details']]);
  header('Location: index.php');
  exit;
}

//全投稿取得
$stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板サンプル</title>
</head>
<body>
  <h1>掲示板サンプル</h1>

  <!--新規投稿フォーム-->
  <h2>新規投稿</h2>
  <form method="post">
    <label>タイトル:<input type="text" name="title" required></label><br>
    <label>種類:
      <select name="category">
        <option value="仕事">仕事</option>
        <option value="生活">生活</option>
        <option value="趣味">趣味</option>
      </select>
</label><br>
<label>詳細:<textarea name="details" required></textarea></label><br>
<button type="submit">投稿</button>
</form>

<!--投稿一覧-->
<h2>投稿一覧</h2>
<?php foreach($posts as $post): ?>
  <div>
   ' <h3>NO:<?php echo htmlspecialchars($post['id'])?> - <?php echo htmlspecialchars($post['title'])?></h3>
    <p>カテゴリ:<?php echo htmlspecialchars($post['category'])?></p>
    <p><?php echo  nl2br(htmlspecialchars($post['details']))?></p>
    <p>作成日: <?php echo htmlspecialchars($post['created_at'])?></p>
    <a href = "?delete=<?php echo $post['id'] ?>">削除</a>
</div>
<hr>
<?php endforeach;?>

</body>
</html>