<? require "header.php"; ?>
<? 
global $link;
$query = mysql_query("SELECT * FROM `itc_guestbook`.`messages` WHERE `id` = ".$_GET['storyid']."",$link) or mysql_error();
$line = mysql_fetch_assoc($query) or mysql_error();
if ($line["id"] === null)
{
	header('Location:/404.php');
	exit; 
}
?>

<?
$haveuser = false;
$imadmin = false;

if (isset($_SESSION["user"])) 
{
	$haveuser = true;
	$adminq = mysql_query("SELECT `admin` FROM `itc_guestbook`.`users` WHERE `login` = '".$_SESSION["user"]."'",$link) or mysql_error();
	$admindata = mysql_fetch_assoc($adminq) or mysql_error();
	$imadmin = false;
	if ($admindata["admin"] != "0")
		$imadmin = true;
}
?>
			<div class="jumbotron">
				<div id="story">
					<h2 style="color: green;"><?=$line["theme"]?></h2>
					<p><?=$line["text"]?></p>
					<div id="details">
						Дата публикации: <?=$line["date"]?>
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
						<?  if ($imadmin && $haveuser)
							{
								echo '<div>';
								echo '<a onclick="edit_message('.$line["id"].')">Изменить</a>';
								echo '&nbsp;&nbsp;';
								echo '<a onclick="delete_message('.$line["id"].')">Удалить</a>';
								echo '</div>';
							} 
						?>
					</div>
				</div>
				
				<div id="type_comment">
					<h2 style="color: green;">Оставьте свой комментарий:</h2>
					<? if (!isset($_SESSION["user"])): ?>
						<h4>Если вы оставляете сообщение анонимно, то вы можете дополнительно ввести свое имя.</h4>
					<? endif; ?>
					<form method="post">
						<input type="hidden" name="TYPE" value="comment" />
						<input type="hidden" name="STORY_ID" value="<?=$_GET['storyid']?>" />
	      	 			<? if (!isset($_SESSION["user"])): ?>
			 				<div class="form-group">
								<input type="text" class="form-control" name="COMMENT_ANONNAME" maxlength="255" placeholder="Имя (желательно)"/>
							</div>
						<? endif; ?>
			 			<div class="form-group">
							<textarea class="form-control" rows="3" name="COMMENT_TEXT"></textarea>
						</div>
			 			<div class="form-group">
							<div class="input-group">
								<?
									$random_string = rand();
									$random_string = sha1($random_string);
									$random_string = substr($random_string, 0, 7);
									$_SESSION["captcha"] = $random_string;
								?>
								<span class="input-group-addon"><img id="captcha_image" src="/captcha.php" alt="captcha image"></span>
								<input type="text" class="form-control" name="COMMENT_CAPTCHA" maxlength="255" placeholder="Captcha"/>
							</div>
						</div>
						<div class="form-group"><button type="submit" class="btn btn-success">Отправить</button></div>
					</form>
					<br/>
				</div>
			
				<div>
					<div class="alert alert-danger" id="comment_hint" role="alert"></div>
				</div>
				
				<div style="text-align: center;">
		      	<? 
		      		global $comments_per_page;
	
					$query = mysql_query("SELECT COUNT(*) as c FROM `itc_guestbook`.`comments` WHERE `message_id` = ".$_GET['storyid'],$link) or mysql_error();
					$line = mysql_fetch_assoc($query) or mysql_error(); 
					$allcmntcount = $line["c"];
						
					if (isset($_GET["page"]))
						$page = $_GET["page"];
					else 
						$page = 1;
	
					$offset = ($page-1)*$comments_per_page;
					$count = $comments_per_page;
					
					$pagecount = ceil($allcmntcount/$comments_per_page);
					if ($pagecount > 1)
					{
						$check = false;
						if (isset($_GET["page"]))
							$check = $_GET["page"];
						else 
							$check = 1;
						
						echo '<ul class="pagination">';
						for ($i = 1; $i <= $pagecount; $i++)
						{
							if ($i == $check)
								echo '<li class="active"><a>'.$i.'<span class="sr-only">(current)</span></a></li>';
							else 
								echo '<li><a href="/message.php/?storyid='.$_GET['storyid'].'&page='.$i.'">'.$i.'</a></li>';		
						}
						echo '</ul>';
					}
		      	?>
	      		</div>
	
				<div id="comments">
					<? 
						$comments_query = mysql_query("SELECT * FROM `itc_guestbook`.`comments` WHERE `message_id` = ".$_GET['storyid']." ORDER BY `id` ASC LIMIT ".$offset.", ".$count,$link) or mysql_error();
						while ($comline = mysql_fetch_array($comments_query, MYSQL_ASSOC)) 
						{ ?>
							<div id="onecomment" class="comment-<?=$comline["id"]?>">
								<div id="comment_head">
									<?=$comline["date"]?>
									<?  if ($imadmin && $haveuser)
										{
											echo '<div>';
											echo '<a class="edit_comment'.$comline["id"].'" onclick="edit_comment('.$comline["id"].')">Изменить</a>';
											echo '&nbsp;&nbsp;';
											echo '<a onclick="delete_comment('.$comline["id"].')">Удалить</a>';
											echo '</div>';
										}
									?>
								</div>
								<div id="comment_body">
									<div id="commentator_info">
									<?
										$comq = mysql_query("SELECT * FROM `itc_guestbook`.`users` WHERE `login` = '".$comline["author"]."'",$link) or mysql_error();
										$comdata = mysql_fetch_assoc($comq) or mysql_error();
										$img = "";
										if ($comdata["admin"] == "1")
										{
											$img = '<img src="/img/admin.gif" title="Администратор" />';
										}
										if ($comdata["blocked"] == "1")
										{
											$img = $img.'<img src="/img/blocked.gif" title="Заблокирован"/>';
										}
										if (($comdata["name"] == "") && ($comdata["surname"] == "")) 
										{
											$comdata["name"] = "Анонимный";
											$comdata["surname"] = "пользователь";
										}
									?>
									<?=$comline["author"].$img." <br/> (".$comdata["name"]." ".$comdata["surname"].")"?>
									<?  
										if ($comline["anonim"] == "0") echo '<br/><img src="/avatars/'.$comdata["avatar"].'"/>';
									?>
									</div>
									<div <?if ($comdata["admin"] == 1) echo 'style="color: red;"'?> id="comment_text">
										<p><?=$comline["text"]?></p>
									</div>
								</div>
							</div>
					 <? } ?>
				</div>
			</div>
<? require "footer.php"; ?>