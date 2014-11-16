<?
	$link = mysql_connect("localhost","root","") or die("ошибка коннекта");
	mysql_select_db("itc_guestbook") or die("ошибка выбора бд");
	mysql_query("SET NAMES utf8",$link);
	
	$messages_per_page = 2;
	$comments_per_page = 2;
?>