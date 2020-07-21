<!--
name    : 片山
date    : 2020.07.21
purpose : 食材情報入力フォーム
-->

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>食材入力画面</title>
  </head>
  <body>
    食材情報入力<br>
    <form action="add.php?user=<?php echo $_GET['user'];?>" method="post">
      食材名：<input type="text" name="shokuzai_name" maxlength="20" required>
      <br>
      量　　：<input type="number" min="1" max"9999" name="amount">(g)
      <br>
      備考　：<input type="text" name="date" maxlength="100">
      <br>
      <input type="submit" value="追加">
      <br><br>
      <a href='home.php?user=<?php echo $_GET['user'];?>'>トップページへ戻る</a>
    </form>
  </body>
</html>
