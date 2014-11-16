<?
session_start();
require "settings.php";
global $link;
$result = array();
$result["status"] = false;
$result["message"] = "";

switch($_POST["TYPE"])
{
	case "auth":
    if(!isset($_SESSION["user"]))
    {
		$query = mysql_query("SELECT COUNT(*) AS auth FROM `itc_guestbook`.`users` WHERE `login` = '".$_POST["USER_LOGIN"]."' AND `password` = '".md5($_POST["USER_PASSWORD"])."'",$link) 
			or mysql_error();
		$data = mysql_fetch_assoc($query) or mysql_error();
		if ($data["auth"] != "0")
		{
			$_SESSION["user"] = $_POST["USER_LOGIN"];
			$result["status"] = true;
			$q = mysql_query("SELECT `blocked` AS block FROM `itc_guestbook`.`users` WHERE `login` = '".$_POST["USER_LOGIN"]."'",$link) or mysql_error();
			$data = mysql_fetch_assoc($q) or mysql_error();
			if ($data["block"] != "0")
			{
				$_SESSION["blocked"] = true;
			}
		}	
		else 
		{
			$result["message"] = "Пользователь с такой комбинацией логина и пароля не найден!";
		}
    }
	break;

	case "register":
    if(!isset($_SESSION["user"]))
    {
		$check = false;
		if ($_POST["USER_NAME"] && $_POST["USER_SURNAME"] && $_POST["USER_LOGIN"] && $_POST["USER_PASSWORD"] && $_POST["USER_CONFIRMPASSWORD"] && $_POST["USER_EMAIL"])
		{
			if ($_POST["USER_PASSWORD"] == $_POST["USER_CONFIRMPASSWORD"])
			{
				$query = mysql_query("SELECT COUNT(*) AS num FROM `itc_guestbook`.`users` WHERE `email` = '".$_POST["USER_EMAIL"]."'",$link) or mysql_error();
				$data = mysql_fetch_assoc($query) or mysql_error();
				if ($data["num"] == "0")
				{
					$query = mysql_query("SELECT COUNT(*) AS log FROM `itc_guestbook`.`users` WHERE `login` = '".$_POST["USER_LOGIN"]."'",$link) or mysql_error();
					$data = mysql_fetch_assoc($query) or mysql_error();
					if ($data["log"] == "0")
					{
						$check = true;
					}
					else 
						$result["message"] = "Данный логин уже занят!";
				}
				else 
					$result["message"] = "Данный Email уже зарегистрирован!";
			}
			else
				$result["message"] = "Пароль потвержден неверно!";
		}
		else 
			$result["message"] = "Для регистрации необходимо заполнить все поля!";
		
		if ($check)
		{
			$query = mysql_query("INSERT INTO `itc_guestbook`.`users` (
			`name`, 
			`surname`, 
			`login`, 
			`password`, 
			`email`, 
			`avatar`
			) 
			VALUES(
			'".$_POST["USER_NAME"]."', 
			'".$_POST["USER_SURNAME"]."', 
			'".$_POST["USER_LOGIN"]."', 
			'".md5($_POST["USER_PASSWORD"])."', 
			'".$_POST["USER_EMAIL"]."', 
			'someone.jpg'
			)"
			,$link) or mysql_error();
			if ($query)
			{
				$_SESSION["user"] = $_POST["USER_LOGIN"];
				$result["status"] = true;
			}
			$result["message"] = "Не удалось зарегистрироваться! Попробуйте позже!";
		}
    }
    break;

	case "logout":
    if(isset($_SESSION["user"]))
    {
		session_destroy();
		$result["status"] = true;
    }
    break;
	
	case "sending":
	if ($_POST["MESSAGE_THEME"] && $_POST["MESSAGE_TEXT"])
	{
		if ($_POST["MESSAGE_CAPTCHA"] == $_SESSION["captcha"])
		{
			$name = "";
			$anonim = "1";
			if (isset($_SESSION["user"]))
			{
				$name = $_SESSION["user"];
				$anonim = "0";
			}
			else 
			{
				if ($_POST["MESSAGE_ANONNAME"])
					$name = $_POST["MESSAGE_ANONNAME"];
				else
					$name = "Без имени";
			}
				
			$query = mysql_query("INSERT INTO `itc_guestbook`.`messages` (
			`author`, 
			`theme`, 
			`text`, 
			`anonim`,  
			`date`
			) 
			VALUES(
			'".$name."', 
			'".$_POST["MESSAGE_THEME"]."', 
			'".$_POST["MESSAGE_TEXT"]."', 
			'".$anonim."', 
			'".date("Y-m-d H:i:s")."'
			)"
			,$link) or mysql_error();
			if ($query)
			{
				$result["status"] = true;
				$result["message"] = "Ваше сообщение успешно добавлено!";
			}
			else 
			{
				$result["message"] = "Не удалось добавить ваше сообщение!";
			}
		}
		else
			$result["message"] = "Капча введена неправильно!";
	}
	else 
		$result["message"] = "Заполните тему и текст сообщения!";
    break;
	
	case "comment":
	if ($_POST["COMMENT_TEXT"])
	{
		if ($_POST["COMMENT_CAPTCHA"] == $_SESSION["captcha"])
		{
			$name = "";
			$anonim = "1";
			if (isset($_SESSION["user"]))
			{
				$name = $_SESSION["user"];
				$anonim = "0";
			}
			else 
			{
				if ($_POST["COMMENT_ANONNAME"])
					$name = $_POST["COMMENT_ANONNAME"];
				else
					$name = "Без имени";
			}
				
			$query = mysql_query("INSERT INTO `itc_guestbook`.`comments` (
			`message_id`,
			`author`, 
			`text`, 
			`anonim`,  
			`date`
			) 
			VALUES(
			'".$_POST["STORY_ID"]."',
			'".$name."',  
			'".$_POST["COMMENT_TEXT"]."', 
			'".$anonim."', 
			'".date("Y-m-d H:i:s")."'
			)"
			,$link) or mysql_error();
			if ($query)
			{
				$result["status"] = true;
				$result["message"] = "Ваш комментарий успешно добавлен!";
			}
			else 
			{
				$result["message"] = "Не удалось добавить ваш комментарий!";
			}
		}
		else
			$result["message"] = "Капча введена неправильно!";
	}
	else 
		$result["message"] = "Нельзя отправить пустое сообщение!";
    break;
	
	case "change_personal":
	if ($_POST["USER_NAME"] && $_POST["USER_SURNAME"] && $_POST["USER_PASSWORD"])
	{
		$query = mysql_query("UPDATE `itc_guestbook`.`users` SET `name` = '".$_POST["USER_NAME"]."' WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
		$query = mysql_query("UPDATE `itc_guestbook`.`users` SET `surname` = '".$_POST["USER_SURNAME"]."' WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
		
		$query = mysql_query("SELECT * FROM `itc_guestbook`.`users` WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
		$data = mysql_fetch_assoc($query) or mysql_error();
		if (md5($_POST["USER_PASSWORD"]) == $data["password"])
		{
			if ($_POST["USER_NEWPASSWORD"] && $_POST["USER_CONFIRMNEWPASSWORD"])
			{
				if ($_POST["USER_NEWPASSWORD"] == $_POST["USER_CONFIRMNEWPASSWORD"])
				{
					$query = mysql_query("UPDATE `itc_guestbook`.`users` SET `password` = '".md5($_POST["USER_NEWPASSWORD"])."' WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
				}
				else 
				{
					$result["message"] = "Новый пароль и его подтверждение не совпадают!";
					exit;
				}
						
			}	
			if (!empty($_FILES['USER_AVATAR']['name']))
			{
				if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['USER_AVATAR']['name']))
				{
					$path_directory = 'avatars/';		
					
					$filename = $_FILES['USER_AVATAR']['name'];
        			$source = $_FILES['USER_AVATAR']['tmp_name'];
        			$target = $path_directory.$filename;
        			move_uploaded_file($source, $target);
						
						
					if(preg_match('/[.](GIF)|(gif)$/', $filename)) 
    					$im = imagecreatefromgif($path_directory.$filename);
					if(preg_match('/[.](PNG)|(png)$/', $filename)) 
						$im = imagecreatefrompng($path_directory.$filename) ;
    				if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename))
						$im = imagecreatefromjpeg($path_directory.$filename);
					
					// Создание квадрата 100x100
					// dest - результирующее изображение 
					// w - ширина изображения 
					// ratio - коэффициент пропорциональности 
					$w = 150; 
					// квадратная 150x150. Можно поставить и другой размер.
					
					// создаём исходное изображение на основе 
					// исходного файла и определяем его размеры 
					$w_src = imagesx($im); //вычисляем ширину
					$h_src = imagesy($im); //вычисляем высоту изображения
					
					// создаём пустую квадратную картинку 
					// важно именно truecolor!, иначе будем иметь 8-битный результат 
					$dest = imagecreatetruecolor($w,$w); 
					
					// вырезаем квадратную серединку по x, если фото горизонтальное 
					if ($w_src>$h_src) 
						imagecopyresampled($dest, $im, 0, 0,
							round((max($w_src,$h_src)-min($w_src,$h_src))/2),
							0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 
					
					// вырезаем квадратную верхушку по y, 
					// если фото вертикальное (хотя можно тоже серединку) 
					if ($w_src < $h_src) 
						imagecopyresampled($dest, $im, 0, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2),
					 		$w, $w, min($w_src,$h_src), min($w_src,$h_src)); 
					
					// квадратная картинка масштабируется без вырезок 
					if ($w_src==$h_src) 
						imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 
							 
					unlink($path_directory.$filename);
					if ($data["avatar"] != "someone.jpg") unlink($path_directory.$_SESSION["user"].".jpg");
					imagejpeg($dest, $path_directory.$_SESSION["user"].".jpg");
					
					$query = mysql_query("UPDATE `itc_guestbook`.`users` SET `avatar` = '".$_SESSION["user"].".jpg"."' WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
				}
				else 
				{
					$result["message"] = "Аватар должен быть в формате .JPG, .GIF или .PNG!";
					exit;
				}
			}
			$result["status"] = true;
		}
		else
			$result["message"] = "Текущий пароль введен неправильно!";
	}
	else 
		$result["message"] = "Имя, фамилия и текущий пароль - обязательные поля!";
    break;
	
	default: break;
}
exit(json_encode($result));
?>