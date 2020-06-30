<!--
name    : 片山
date    : 2020.06.30
purpose : アカウント作成処理
-->

<?php
  $err_msg = "";

  if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == null or $password == null)
      $err_msg = "ユーザ名またはパスワードを入力してください";
    else {
      try {
        $db = new PDO('mysql:host=localhost;dbname=sample', 'hogeUser', 'hogePass');
        $sql2 = 'select count(*) from users where username=?';
        $stmt = $db->prepare($sql2);
        $stmt->execute(array($username));
        $result = $stmt->fetch();
        $stmt = null;

        if ($result[0] != 0) {
          $err_msg = "入力されたユーザ名は既に使われています";
        } else {
          $sql2 = 'insert into users(username, password) value(?, ?)';
          $stmt = $db->prepare($sql2);
          $stmt->execute(array($username, $password));
          $stmt = null;
          $db = null;
          header('Location: http://localhost/login/signin.php');
          exit;
        }
      } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
      }
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新規登録画面</title>
  </head>
  <body>

    <h1>新規登録画面</h1>
    <form action="" method="post">
      <?php if ($err_msg !== null && $err_msg !== '') {echo $err_msg . "<br>";} ?>
      ユーザ名　<input type="text" name="username" value=""><br>
      パスワード<input type="password" name="password" value=""><br>
      <input type="submit" name="signup" value="新規登録">
    </form>

  </body>
</html>
