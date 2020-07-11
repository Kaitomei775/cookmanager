<?php
  $user = "hogeUser";
  $pass = "hogePass";
  try {
    if (empty($_GET['id'])) throw new Exception('ID不正');
    $id = (int) $_GET['id'];
    $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM shokuzai WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
  } catch (Exception $e) {
    echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
  }
 ?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>入力フォーム</title>
  </head>
  <body>
    <form method="post" action="update.php">
      食材名：<input type="text" name="shokuzai_name" value="<?php echo htmlspecialchars($result['shokuzai_name'], ENT_QUOTES, 'UTF-8'); ?>">
      <br>
      量　　：<input type="number" name="amount" value="<?php echo htmlspecialchars($result['amount'], ENT_QUOTES, 'UTF-8'); ?>">(g)
      <br>
      期限　：<input type="text" name="date" value="<?php echo htmlspecialchars($result['date'], ENT_QUOTES, 'UTF-8'); ?>">
      <br>
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
      <input type="submit" value="変更">
    </form>
    <br>
    <a href='home.php'>トップページへ戻る</a>
  </body>
</html>
