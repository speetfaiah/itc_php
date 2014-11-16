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
		<? session_start(); ?>
		<h2>Вы были заблокированы!</h2>
		<? session_destroy(); ?>
	</body>
</html>