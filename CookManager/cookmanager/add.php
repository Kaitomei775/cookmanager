<!--
name    : 片山
date    : 2020.07.21
purpose : 新規食材追加処理
-->

<?php
  $user = "hogeUser";
  $pass = "hogePass";
  $username = $_GET['user'];
  $shokuzai_name = $_POST['shokuzai_name'];
  $amount = (int) $_POST['amount'];
  $date = $_POST['date'];
  try {
      $dbh = new PDO('mysql:host=160.16.141.77:61000;dbname=db_shokuzai;charset=utf8', $user, $pass);
      $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO shokuzai (user, shokuzai_name, amount, date) VALUES(?, ?, ?, ?)";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1, $username, PDO::PARAM_STR);
      $stmt->bindValue(2, $shokuzai_name, PDO::PARAM_STR);
      $stmt->bindValue(3, $amount, PDO::PARAM_INT);
      $stmt->bindValue(4, $date, PDO::PARAM_STR);
      $stmt->execute();
      $dbh = null;
      echo "食材の登録が完了しました。<br>";
      echo "<a href='home.php?user=" . $_GET['user'] . "'>トップページへ戻る</a>";
  } catch (Exception $e) {
    echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
  }
 ?>
