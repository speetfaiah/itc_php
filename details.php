<?
	session_start();
	require "settings.php";
	global $link;
	$query = mysql_query("SELECT * FROM `itc_guestbook`.`messages` WHERE `id` = ".$_GET['storyid']."",$link) or mysql_error();
	$line = mysql_fetch_assoc($query) or mysql_error();
?>
	<h2 style="color: green;"><?=$line["theme"]?></h2>
	<p><?=$line["text"]?></p>
	<div id="details">
		Дата публикации: <?=$line["date"]?>
		<br/>
		<?
			$q = mysql_query("SELECT `name`,`surname`,`admin`,`blocked` FROM `itc_guestbook`.`users` WHERE `login` = '".$line["author"]."'",$link) or mysql_error();
			$data = mysql_fetch_assoc($q) or mysql_error();
			$img = "";
			if ($data["admin"] == "1")
			{
				$img = '<img src="/img/admin.gif" title="Администратор" />';
			}
			if ($data["blocked"] == "1")
			{
				$img = $img.'<img src="/img/blocked.gif" title="Заблокирован"/>';
			}
			if (($data["name"] == "") && ($data["surname"] == "")) 
			{
				$data["name"] = "Анонимный";
				$data["surname"] = "пользователь";
			}
		?>
		Автор: <?=$line["author"].$img." (".$data["name"]." ".$data["surname"].")"?>
	</div>
	<br/>
	<a href="/message.php/?storyid=<?=$_GET['storyid']?>">Посмотреть комментарии</a>