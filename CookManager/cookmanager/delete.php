<!--
name    : 片山
date    : 2020.07.21
purpose : 食材削除処理
-->

<?php
  $user = "hogeUser";
  $pass = "hogePass";
  try {
    if (empty($_GET['id'])) throw new Exception('ID不正');
    $id = (int) $_GET['id'];
    $dbh = new PDO('mysql:host=160.16.141.77:61000;dbname=db_shokuzai;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM shokuzai WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo "食材の削除が完了しました。<br>";
    echo "<a href='home.php?user=" . $_GET['user'] . "'>トップページへ戻る</a>";
  } catch (Exception $e) {
    echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
  }
 ?>
