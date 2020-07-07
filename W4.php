<!--
name    : 山本
date    : 2020/07/07
purpose : レシピ表示
-->

<?php

	$dsn = 'mysql:dbname=aaa;host=localhost'; //userのデータベースをまずはもらう
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn,$syokuzai,$recepi,$recipiURL);
	$dbh = query('SET NAME utf8');
	//userのデータベースに接続するプログラム

	$user = $_POST['user']; //user情報を貰う
	$syokuzai = $_POST['syokuzai']; //食材情報を貰う
	if($syokuzai == '')//食材が空だったら
	{
		print'食材がありません';
	}

	$dbh = null;//userのデータベースを閉じる



	$dsn = 'mysql:dbname=aaa;host=localhost'; //レシピのデータベースをまずはもらう
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn,$syokuzai,$recepi,$recipiURL);
	$dbh = query('SET NAME utf8');

	$syokuzai = $_POST['syokuzai'];
    $recipe = $_POST['recipe'];
	$recipeURL = $_POST['recipeURL'];

	
	print $recipe;
	print $recipeURL;

?>