<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>MY冷蔵庫</title>
  </head>
  <body>
    <h1>MY冷蔵庫</h1>
    <a href="inform.html">食材の新規登録</a>
    <?php
      // session_start();
      // if (isset($_SESSION["username"])) {
      //   print "<p>";
      //   print "こんにちは、" . $_SESSION["username"] . "さん。";
      //   print "</p>";
      // }

      try {
        $user = "hogeUser";
        $pass = "hogePass";
        $dbh = new PDO('mysql:host=localhost;dbname=db1;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM shokuzai";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<table>\n";
        echo "<tr>\n";
        echo "<th>食材名</th><th>量</th><th>期限</th>\n";
        echo "</tr>\n";
        foreach ($result as $row) {
          echo "<tr>\n";
          echo "<td>" . htmlspecialchars($row['shokuzai_name'], ENT_QUOTES, 'UTF-8') . "</td>\n";
          echo "<td>" . htmlspecialchars($row['amount'], ENT_QUOTES, 'UTF-8') . "(g)</td>\n";
          echo "<td>" . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . "</td>\n";
          echo "<td>\n";
          echo "<a href=edit.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">変更</a>\n";
          echo "|<a href=delete.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">削除</a>\n";
          echo "</td>\n";
          echo "</tr>\n";
        }
        echo "</table>\n";
        $dbh = null;
      } catch (Exception $e) {
        echo "error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }
    ?>
  </body>
</html>
