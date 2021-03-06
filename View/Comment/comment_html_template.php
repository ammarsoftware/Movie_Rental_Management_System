
<?php
	//if user login
	session_start();
	if(isset($_SESSION['customer'])) {
?>
		<html>
			<head>
				<title>Comment</title>
				<link rel="stylesheet" type="text/css" href="Style/comment_style.css">
			</head>
			<body>
				<nav id="menu" class="panel" role="navigation">
        			<?php include("side_bar_template.php"); ?>
    			</nav>
    			
    			<div id="Main" class="wrap push">
    				<div id="Id_Button">
						<a href="#menu" class="menu-link">&#9776;</a>
					</div>
    				
					<div class="Content">
						<div class="ContentCover">
							<img src="Cover/<?= $movie->getCover() ?>" alt="<?= $movie->getTitle() ?>" />
						</div>
												
						<div class="ContentText">
							<table id="Movie_Table">
								<tr>
									<td>&nbsp&nbsp<b><font size="7px"><?= $movie->getTitle() ?></font></b></td>
								</tr>
								<tr>
									<td><i><?= $movie->getGenre() ?></i></td>
								</tr>
								
								<tr>
									<td><?= $movie->getDuration() ?></td>
								</tr>
								<tr>
									<td><br><b>&euro;<?= $movie->getPrice() ?></b></td>
								</tr>
							</table>
						</div>
								
						<div class="BackB">						
							<a href="./index.php"><input class="Button2" type="button" value="Back" /></a>
						</div>
						<div class=RentB>			
							<form method="POST" action="">
								<input class="Button" type="submit" value="Rent" onclick="return confirm('Are you sure to rent?')" />
								
								<input type="hidden" name="action" value="rent" />
								<input type="hidden" name="cost" value="<?= $movie->getPrice() ?>" />
								<input type="hidden" name="movie_id" value="<?= $movie->getId() ?>" />
								<input type="hidden" name="movie_title" value="<?= $movie->getTitle() ?>" />
								<input type="hidden" name="customer_id" value="<?= $_SESSION['customer']->getId() ?>" />
								<input type="hidden" name="customer_email" value="<?= $_SESSION['customer']->getEmail() ?>" />								
							</form>
						
						</div>
					</div>
						
					<div class="Comment_Block">
						<div class="Comments">
						<?php 
							$comments = $this->model->getAllCommentsByMovieID($movie->getID());
						
							if(count($comments) > 0) {
								foreach($comments as $comment) {
									$customer = $this->model->getCustomerByID($comment->getCustomerID());
						?>
					
							
								<div class="Comment_User"><?= $customer->getUsername() ?> (<?= $comment->getStar() ?>) :</div>
								<div class="Comment_Content">&nbsp; &nbsp;<?= $comment->getContent() ?></div>						
								 		
															
						<?php 
								}
							} 
						?>
						</div>
						<div class="Comment_Space">
							<textarea id="Text_Area" name="content" form="Comment_Form" rows="4" cols="50" placeholder="Add a Comment and Rate the movie..."></textarea>
								
							
							<select form="Comment_Form" name="star">
								<option>0</option>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
							
							<form id="Comment_Form" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
								<input type="submit" value="Comment" />
								<input type="hidden" name="action" value="comment" />
								<input type="hidden" name="movie_id" value="<?= $movie->getId() ?>" />
								<input type="hidden" name="customer_id" value="<?= $_SESSION['customer']->getId() ?>" />
							</form>
						</div>
						
					</div>
				</div>
				
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    			<script src="./bigSlide.js"></script>
    			<script>
        		$(document).ready(function() {
            		$('.menu-link').bigSlide();
        		});
    			</script>
    			
			</body>
		</html>
<?php
	//if user didn't login
	} else {
		header('Location: ./login.php?error=3');								/* redirect to login page */
	}
?>