<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=8889;dbname=bulletin_board;charset=utf8','root','root');

//投稿取得処理
if(isset($_GET['id'])){
  $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
  $stmt->execute([$_GET['id']]);
  $post = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$post){
    die('投稿が見つかりません');
  }
}

//投稿編集処理
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $stmt = $pdo->prepare('UPDATE posts SET title = ?, category = ?, details = ? WHERE id = ?');
  $stmt->execute([$_POST['title'],$_POST['category'],$_POST['details'],$_POST['id']]);
  header('Location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿編集</title>
</head>
<body>
<h1>投稿編集</h1>
<form method="post">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id'])?>">
  <label>カテゴリ:
    <select name="category">
      <option value="仕事"<?php echo $post['category'] == '仕事' ? 'selected' : ''?>>仕事</option>
      <option value="生活"<?php echo $post['category'] == '生活' ? 'selected' : ''?>>生活</option>
      <option value="趣味"<?php echo $post['category'] == '趣味' ? 'selected' : ''?>>趣味</option>
    </select>
  </label><br>
  <label>詳細:<textarea name="details" required><?php echo htmlspecialchars($post['details'])?></textarea></label><br>
  <button type="submit">更新</button>
</form>
<a href="index.php">戻る</a>
</body>
</html>