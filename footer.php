			<div class="footer">
				<p>&copy; 2014</p>
			</div>
	      
			<div class="wrapping">
				<?if (!isset($_SESSION["user"])): ?>
	      		<div class="window auth_form">
	      			<div class="window_header">
	      				<div class="col-md-8"><h2>Авторизация</h2></div>
	  					<div class="col-md-4"><span class="close glyphicon glyphicon-remove"></span></div>
					</div>
					<div class="window_content">
						<form method="post">
							<input type="hidden" name="TYPE" value="auth" />
							<div class="form-group">
	    						<input type="text" class="form-control" name="USER_LOGIN" maxlength="255" placeholder="Логин"/>
	  						</div>
							<div class="form-group">
	    						<input type="password" class="form-control" name="USER_PASSWORD" maxlength="255" placeholder="Пароль" />
	  						</div>
							<div class="form-group"><button type="submit" class="btn btn-success">Войти</button></div>
						</form>
						<br/>
						<div class="alert alert-danger" id="auth_hint" role="alert"></div>
						<br/>
					</div>
	      		</div>
	      		<div class="window register_form">
	      			<div class="window_header">
	      				<div class="col-md-8"><h2>Регистрация</h2></div>
	  					<div class="col-md-4"><span class="close glyphicon glyphicon-remove"></span></div>
					</div>
					<div class="window_content">
						<form method="post">
							<input type="hidden" name="TYPE" value="register" />
							<div class="form-group">
	    						<input type="text" class="form-control" name="USER_NAME" maxlength="255" placeholder="Имя"/>
	  						</div>
							<div class="form-group">
	    						<input type="text" class="form-control" name="USER_SURNAME" maxlength="255" placeholder="Фамилия"/>
	  						</div>
							<div class="form-group">
	    						<input type="text" class="form-control" name="USER_LOGIN" maxlength="255" placeholder="Логин"/>
	  						</div>
							<div class="form-group">
	    						<input type="password" class="form-control" name="USER_PASSWORD" maxlength="255" placeholder="Пароль" />
	  						</div>
							<div class="form-group">
	    						<input type="password" class="form-control" name="USER_CONFIRMPASSWORD" maxlength="255" placeholder="Подтверждение пароля" />
	  						</div>
							<div class="form-group">
	    						<input type="email" class="form-control" name="USER_EMAIL" maxlength="255" placeholder="Email" />
	  						</div>
							<div class="form-group"><button type="submit" class="btn btn-success">Зарегистрироваться</button></div>
						</form>
						<br/>
						<div class="alert alert-danger" id="register_hint" role="alert"></div>
						<br/>
					</div>
				</div>
				<?endif;?>
			</div>
		</div>
	</body>
</html>
