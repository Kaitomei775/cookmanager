<!--
name    : 片山
date    : 2020.06.30
purpose : アカウント新規作成処理
-->

<?php
  $err_msg = "";
  if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_test = $_POST['password_test'];
    if ($username == null || $password == null || $password_test == null)
      $err_msg = "ユーザ名またはパスワードを入力してください";
    else if ($password != $password_test)
      $err_msg = "パスワードが一致していません";
    else {
      try {
        $db = new PDO('mysql:host=160.16.141.77:61000;dbname=db_user', 'hogeUser', 'hogePass');
        $sql = 'select count(*) from users where username=?';
        $stmt = $db->prepare($sql);
        $stmt->execute(array($username));
        $result = $stmt->fetch();
        $stmt = null;
        if ($result[0] != 0) {
          $err_msg = "入力されたユーザ名は既に使われています";
        } else {
          $sql = 'insert into users(username, password) value(?, ?)';
          $stmt = $db->prepare($sql);
          $stmt->execute(array($username, $password));
          $stmt = null;
          $db = null;
          header('Location: signin.php');
          exit;
        }
      } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
      }
    }
  }
  if (isset($_POST['back'])) {
    header('Location: signin.php');
  }
?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="signup.css" />
<html>
  <head>
    <meta charset="utf-8">
    <title>新規登録画面</title>
  </head>
  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Sign<span>up</span></div>
		</div>
		<br>
  <body>
  <div class="signup">
    <form action="" method="post">
      <?php if ($err_msg !== null && $err_msg !== '') {echo $err_msg . "<br>";} ?>
      ユーザ名(4文字以上16文字以内の半角英数字)<br>
      <input type="text" pattern="[a-zA-Z0-9]+" name="username" minlength="4" maxlength="16" value=""><br>
      パスワード(4文字以上16文字以内の半角英数字)<br>
      <input type="password" pattern="[a-zA-Z0-9]+" name="password" minlength="4" maxlength="16" value=""><br>
      パスワード(確認用)<br>
      <input type="password" pattern="[a-zA-Z0-9]+" name="password_test" minlength="4" maxlength="16"  value=""><br>
      <input type="submit" name="signup" value="新規登録"><br>
      <input type="submit" name="back" value="戻る">
    </form>
  </body>
</html>
