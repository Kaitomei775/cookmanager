<!--
name    : 片山
date    : 2020.07.21
purpose : 食材情報更新処理
-->

<?php
  $user = "hogeUser";
  $pass = "hogePass";
  $shokuzai_name = $_POST['shokuzai_name'];
  $amount = (int) $_POST['amount'];
  $date = $_POST['date'];
  try {
    if (empty($_POST['id'])) throw new Exception("ID不正");
    $id = (int) $_POST['id'];
    $dbh = new PDO('mysql:host=160.16.141.77:61000;dbname=db_shokuzai;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE shokuzai SET shokuzai_name = ?, amount = ?, date = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $shokuzai_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $amount, PDO::PARAM_INT);
    $stmt->bindValue(3, $date, PDO::PARAM_STR);
    $stmt->bindValue(4, $id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo "食材の更新が完了しました。<br>";
    echo "<a href='home.php?user=" . $_GET['user'] . "'>トップページへ戻る</a>";
  } catch (Exception $e) {
    echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
  }
 ?>
