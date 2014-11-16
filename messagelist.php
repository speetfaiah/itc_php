<?
	global $link;
	global $messages_per_page;
	
	$query = mysql_query("SELECT COUNT(*) as c FROM `itc_guestbook`.`messages`",$link) or mysql_error();
	$line = mysql_fetch_assoc($query) or mysql_error(); 
	$allmsgcount = $line["c"];
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else 
		$page = 1;
	
	$offset = ($page-1)*$messages_per_page;
	$count = $messages_per_page;
	
	$query = mysql_query("SELECT * FROM `itc_guestbook`.`messages` ORDER BY `date` DESC LIMIT ".$offset.", ".$count,$link) or mysql_error();
	while ($line = mysql_fetch_array($query, MYSQL_ASSOC)) 
	{ ?>
	<div id="onestory" class="story-<?=$line["id"]?>">
		<div id="theme">
			<a onclick="show_details(<?=$line["id"]?>)"><?=$line["theme"]?></a>
		</div>
		<div id="details">
			<?=$line["date"]?>
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
	</div>
	<?}
?>