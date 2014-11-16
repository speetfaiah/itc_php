<? require "header.php"; ?>
			<div class="jumbotron">
				<div class="row">
  					<div class="col-md-4">
  						<? require "messagelist.php"; ?>
  					</div>
  					<div class="col-md-8">
  						<h2>Выберите историю.</h2>
  					</div>
				</div>
	      	</div>
	      	<div style="text-align: center;">
		      	<? 
		      		global $messages_per_page;
					global $allmsgcount;
					
					$pagecount = ceil($allmsgcount/$messages_per_page);
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
								echo '<li class="active"><a href="#">'.$i.'<span class="sr-only">(current)</span></a></li>';
							else 
								echo '<li><a href="/?page='.$i.'">'.$i.'</a></li>';		
						}
						echo '</ul>';
					}
		      	?>
	      	</div>
<? require "footer.php"; ?>