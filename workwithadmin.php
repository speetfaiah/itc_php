<?
session_start();
require "settings.php";
global $link;
$result = array();
$result["status"] = false;
$result["message"] = "";

switch($_POST["TYPE"])
{
	case "edit_comment":
		if ($_POST["COMMENT_TEXT"])
		{
			$query = mysql_query("UPDATE `itc_guestbook`.`comments` SET `text` = '".$_POST["COMMENT_TEXT"]."' WHERE `comments`.`id` = ".$_POST["COMMENT_ID"],$link) or mysql_error();
			$result["status"] = true;
			$result["message"] = "Комментарий #".$_POST["COMMENT_ID"]." успешно изменен!";
		}
		else 
			$result["message"] = "Комментарий не может быть пустым!";
	break;

	case "delete_comment":
		$query = mysql_query("DELETE FROM `itc_guestbook`.`comments` WHERE `id` = ".$_POST["COMMENT_ID"],$link) or mysql_error();
		$result["status"] = true;
		$result["message"] = "Комментарий #".$_POST["COMMENT_ID"]." успешно удален!";
    break;
	
	case "edit_message":
		if ($_POST["MESSAGE_TEXT"] && $_POST["MESSAGE_THEME"])
		{
			$query = mysql_query("UPDATE `itc_guestbook`.`messages` SET `text` = '".$_POST["MESSAGE_TEXT"]."' WHERE `messages`.`id` = ".$_POST["MESSAGE_ID"],$link) or mysql_error();
			$query = mysql_query("UPDATE `itc_guestbook`.`messages` SET `theme` = '".$_POST["MESSAGE_THEME"]."' WHERE `messages`.`id` = ".$_POST["MESSAGE_ID"],$link) or mysql_error();
			$result["status"] = true;
			$result["message"] = "Сообщение #".$_POST["MESSAGE_ID"]." успешно изменено!";
		}
		else 
			$result["message"] = "Заполните тему и текст сообщения!";
    break;
	
	case "delete_message":
		$query = mysql_query("DELETE FROM `itc_guestbook`.`messages` WHERE `id` = ".$_POST["MESSAGE_ID"],$link) or mysql_error();
		$query = mysql_query("DELETE FROM `itc_guestbook`.`comments` WHERE `message_id` = ".$_POST["MESSAGE_ID"],$link) or mysql_error();
		$result["status"] = true;
		$result["message"] = "Сообщение #".$_POST["MESSAGE_ID"]." успешно удалено!";
    break;
	
	case "block_user":
		$query = mysql_query("SELECT * FROM `itc_guestbook`.`users` WHERE `id` = ".$_POST["USER_ID"],$link) or mysql_error();
		$data = mysql_fetch_assoc($query) or mysql_error();
		$bl = -1;
		if ($data["blocked"] == 1) $bl = 0;
			else $bl = 1;
		$query = mysql_query("UPDATE `itc_guestbook`.`users` SET `blocked` = ".$bl." WHERE `users`.`id` = ".$_POST["USER_ID"],$link) or mysql_error();
		$result["status"] = true;
	break;
}
exit(json_encode($result));
?>