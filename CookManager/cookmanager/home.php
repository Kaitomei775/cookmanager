<!--
name    : 片山
date    : 2020.07.21
purpose : ホーム画面(食材一覧表示処理)
-->

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>MY冷蔵庫</title>
  </head>
  <body>
    <link rel="stylesheet" href="cookmanager.css" type="text/css">
	<div class="smple1">
	<header>
		<font size=7>
			<div align=center>
			  <i><b><font color="white">　Cookmanager　</font></b></i><br>
      </div>
		</font>
	</header>
    <h1>MY冷蔵庫</h1>
    <?php
      try {
        $user = "hogeUser";
        $pass = "hogePass";
        $username = $_GET['user'];
        $dbh = new PDO('mysql:host=160.16.141.77:61000;dbname=db_shokuzai;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM shokuzai";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<table border='1'>\n";
        echo "<tr>\n";
        echo "<th>食材名</th><th>量</th><th>備考</th>\n";
        echo "</tr>\n";
        foreach ($result as $row) {
          if ($row['user'] == $username) {
          echo "<tr>\n";
          echo "<td>" . htmlspecialchars($row['shokuzai_name'], ENT_QUOTES, 'UTF-8') . "</td>\n";
          echo "<td>" . htmlspecialchars($row['amount'], ENT_QUOTES, 'UTF-8') . "(g)</td>\n";
          echo "<td>" . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . "</td>\n";
          echo "<td>\n";
          echo "<a href=edit.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">変更</a>\n";
          ?>
          |<a href=delete.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>&user=<?php echo $username ?> onclick="return confirm('<?php echo htmlspecialchars($row['shokuzai_name'], ENT_QUOTES, 'UTF-8'); ?>を削除しますか？')">削除</a>
          <?php
          echo "|<a href=recipe.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "&user=" . $username . ">検索</a>\n";
          echo "</td>\n";
          echo "</tr>\n";
        }
        }
        echo "</table>\n";
        $dbh = null;
      } catch (Exception $e) {
        echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }
    ?>
	<div class="button">
    <a href="inform.php?user=<?php echo $_GET['user']; ?>">食材の新規登録</a>
    </div>
    <br><br>
    <a href='signin.php'>ログアウト</a>
  </body>
  </div>
</html>
