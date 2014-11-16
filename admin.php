<? require "header.php";
if (!isset($_SESSION["user"]))
{
	header('Location:/404.php');
	exit; 
}
$q = mysql_query("SELECT * FROM `itc_guestbook`.`users` WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
$data = mysql_fetch_assoc($q) or mysql_error();
if ($data["admin"] != "1")
{
	header('Location:/404.php');
	exit; 
}
?>

	<h2>Список пользователей сайта</h2>
	<table class="table table-bordered">
		<tr class="info">
			<th>Аватар</th>
			<th>Логин</th>
			<th>Имя</th>
			<th>Фамилия</th>
			<th>Email</th>
			<th>Админ?</th>
			<th></th>
		</tr>
	<? 
	$query = mysql_query("SELECT * FROM `itc_guestbook`.`users` ORDER BY `id` ASC",$link) or mysql_error();
	while ($line = mysql_fetch_array($query, MYSQL_ASSOC)) 
	{?>
		<tr>
			<td>
				<img src="/avatars/<?=$line['avatar']?>" />
			</td>
			<td>
				<?=$line["login"]?>
			</td>
			<td>
				<?=$line["name"]?>
			</td>
			<td>
				<?=$line["surname"]?>
			</td>
			<td>
				<?=$line["email"]?>
			</td>
			<td>
				<?
					if ($line["admin"] == 1) echo "Да";
					else echo "Нет";
				?>
			</td>
			<td>
				<?
					$bl = "";
					if ($line["blocked"] == 1) $bl = "Разблокировать";
					else $bl = "Блокировать";
					
					echo '<a href="#block'.$line["id"].'" onclick="block_user('.$line["id"].')">'.$bl.'</a>';
				?>
			</td>
		</tr>
	<?}
	?>
	</table>

<? require "footer.php"; ?>