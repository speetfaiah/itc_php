<? require "header.php"; ?>
	      	<div class="row marketing">
	      	 	<h2>Оставьте свое сообщение!</h2>
				<h3>Введите тему и текст сообщения, а также капчу для отправки сообщения.</h3>
				<? if (!isset($_SESSION["user"])): ?>
				<h4>Если вы оставляете сообщение анонимно, то вы можете дополнительно ввести свое имя.</h4>
				<? endif; ?>
				<form method="post">
					<input type="hidden" name="TYPE" value="sending" />
	      	 		<? if (!isset($_SESSION["user"])): ?>
			 		<div class="form-group">
						<input type="text" class="form-control" name="MESSAGE_ANONNAME" maxlength="255" placeholder="Имя (желательно)"/>
					</div>
					<? endif; ?>
			 		<div class="form-group">
						<input type="text" class="form-control" name="MESSAGE_THEME" maxlength="255" placeholder="Тема"/>
					</div>
			 		<div class="form-group">
						<textarea class="form-control" rows="3" name="MESSAGE_TEXT"></textarea>
					</div>
			 		<div class="form-group">
						<div class="input-group">
							<?
								$random_string = rand();
								$random_string = sha1($random_string);
								$random_string = substr($random_string, 0, 7);
								$_SESSION["captcha"] = $random_string;
							?>
							<span class="input-group-addon"><img id="captcha_image" src="captcha.php" alt="captcha image"></span>
							<input type="text" class="form-control" name="MESSAGE_CAPTCHA" maxlength="255" placeholder="Captcha"/>
						</div>
					</div>
					<div class="form-group"><button type="submit" class="btn btn-success">Отправить</button></div>
				</form>
				<br/>
			</div>
			
			<div>
				<div class="alert alert-danger" id="sending_hint" role="alert"></div>
			</div>
<? require "footer.php"; ?>