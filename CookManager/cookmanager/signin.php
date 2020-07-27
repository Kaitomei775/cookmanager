<!--
name    : 片山
date    : 2020.07.21
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
        $db = new PDO('mysql:host=160.16.141.77:61000;dbname=db_user', 'hogeUser', 'hogePass');
        $sql = 'select count(*) from users where username=? and password=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($username, $password));
        $result = $stmt->fetch();
        $stmt = null;
        $db = null;
        if ($result[0] != 0) {
          header('Location: home.php?user=' . htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));
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
  if (isset($_POST['signup'])) {
    header('Location: signup.php');
  }
?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="signin.css" />
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン画面</title>
  </head>
  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Sign<span>in</span></div>
		</div>
		<br>
		<div class="login">
    <form action="" method="post">
      <?php if ($err_msg !== null && $err_msg !== '') {echo $err_msg . "<br>";} ?>
      ユーザ名<br>
      <input type="text" pattern="[a-zA-Z0-9]+" name="username" minlength="4" maxlength="16" value=""><br>
      パスワード<br>
      <input type="password" pattern="[a-zA-Z0-9]+" name="password" minlength="4" maxlength="16" value=""><br>
      <input type="submit" name="login" value="ログイン"><br>
      <input type="submit" name="signup" value="新規登録">
    </form>
  </div>
</html>
