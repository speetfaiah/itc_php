<? require "header.php";
if (!isset($_SESSION["user"]))
{
	header('Location:/index.php');
	exit; 
}
$q = mysql_query("SELECT * FROM `itc_guestbook`.`users` WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
$data = mysql_fetch_assoc($q) or mysql_error();
?>
	      	<div class="row marketing personal_form">
	      	 	<h2>Измените свои данные!</h2>
				<form enctype="multipart/form-data" method="post">
					<input type="hidden" name="TYPE" value="change_personal" />
			 		<div class="form-group">
			 			<img id="avatar" src="/avatars/<?=$data["avatar"]?>" alt="avatar"/>
						<input type="file" accept="image/*" class="form-control" id="USER_AVATAR" name="USER_AVATAR" onchange="preview_image()" />
					</div>
			 		<div class="form-group">
						<input type="text" class="form-control" name="USER_NAME" maxlength="255" placeholder="Имя" value="<?=$data["name"]?>"/>
					</div>
			 		<div class="form-group">
						<input type="text" class="form-control" name="USER_SURNAME" maxlength="255" placeholder="Фамилия" value="<?=$data["surname"]?>"/>
					</div>
			 		<div class="form-group">
						<input type="password" class="form-control" name="USER_NEWPASSWORD" maxlength="255" placeholder="Новый пароль"/>
					</div>
			 		<div class="form-group">
						<input type="password" class="form-control" name="USER_CONFIRMNEWPASSWORD" maxlength="255" placeholder="Подтверждение нового пароля"/>
					</div>
					<h3>Для сохранения данных введите текущий пароль</h3>
					<div class="form-group">
						<input type="password" class="form-control" name="USER_PASSWORD" maxlength="255" placeholder="Текущий пароль"/>
					</div>
					<div class="form-group"><button type="submit" class="btn btn-success">Сохранить изменения</button></div>
				</form>
				<br/>
			</div>
			
			<div>
				<div class="alert alert-danger" id="personal_hint" role="alert"></div>
			</div>
<? require "footer.php"; ?>