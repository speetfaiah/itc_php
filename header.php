<? 
session_start();
require "settings.php";
if (isset($_SESSION["blocked"]))
{
	header('Location:/blocked.php');
	exit; 
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>ITC - Гостевая книга</title>
	    <link href="/css/bootstrap.css" rel="stylesheet">
	    <link href="/css/jumbotron.css" rel="stylesheet">
	    <link href="/css/style.css" rel="stylesheet">
	    
	    <script src="/js/jquery-2.1.1.js"></script>
	    <script src="/js/jquery.form.min.js"></script>
	    <script src="/js/script.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="header">
				<ul class="nav nav-pills pull-right">
					<li><a href="/addmessage.php">Добавить сообщение</a></li>
	        	<? if (isset($_SESSION["user"])): ?>
		    		<li><h4>Привет, <a href="/personal.php"><?=$_SESSION["user"];?></a></h4></li>
		    		<li>
						<form method="post">
							<input type="hidden" name="TYPE" value="logout" />
							<button type="submit" class="btn btn-danger logout">Выйти</button>
						</form>
					</li>
		    	<? else: ?>
		    		<li><button type="button" class="btn btn-primary auth">Авторизация</button></li>
		        	<li><button type="button" class="btn btn-primary register">Регистрация</button></li>
		    	<? endif; ?>
	        	</ul>
	        	<h3 class="text-muted"><a href="/">Гостевая книга</a></h3>
	      	</div>