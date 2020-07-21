<!--
name    : 片山
date    : 2020.06.30
purpose : ログイン処理
-->

<?php

  $err_msg = "";

  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == null or $password == null)
      $err_msg = "ユーザ名またはパスワードを入力してください";
    else {
      try {
        $db = new PDO('mysql:host=127.0.0.1:61000;dbname=db_user;charset=utf8', 'hogeUser', 'hogePass');
        $sql = 'select count(*) from users where username=? and password=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($username, $password));
        $result = $stmt->fetch();
        $stmt = null;
        $db = null;

        if ($result[0] != 0) {
          header('Location: home.php');
          session_start();
          session_cache_expire(1);
          $_SESSION["username"] = $username;
          exit;
        } else {
          $err_msg = "ユーザ名またはパスワードが違います";
        }

      } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
      }
    }
  }
  echo exec('mkdir sample');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン画面</title>
  </head>
  <body>

    <h1>ログイン画面</h1>
    <form action="" method="post">
      <?php if ($err_msg !== null && $err_msg !== '') {echo $err_msg . "<br>";} ?>
      ユーザ名　<input type="text" name="username" value=""><br>
      パスワード<input type="password" name="password" value=""><br>
      <input type="submit" name="login" value="ログイン">
    </form>
    <a href="signup.php">新規登録</a>

  </body>
</html>
