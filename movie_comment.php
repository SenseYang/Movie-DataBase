<!--This page is used to add movie comments-->
										<?php
										require_once('facilities.php');
										page_head('Movie Comment');
										$db_connection = getConnection();
										?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Movie Comment</h2>
		</div>
	</div>
												<?php
												$movieID = $_GET['Movie_id'];
													if(empty($movieID)){
														$noInputMovieID = true;
													}
													else{
														$noInputMovieID = false;
														$action = $_SERVER['PHP_SELF'] . "?Movie_id=" . $movieID;
													}
													if($noInputMovieID){
														
												?>
	<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
												<?php
													}
													else{
												?>
	<form method = "POST" action = "<?php echo $action;?>">
												<?php
													}
												?>
	<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Name:</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<textarea name = "Review_name"></textarea>
		</div>
		<div class="col-md-4">
			<h4>e.g <I>Skyfans</I></h4>
		</div>
	</div>
			<!--time should not be a input value-->
			<!--if it is linked from movie info page, then it should not have movie id input box-->
													<?php
													if($noInputMovieID){
													?>
    <div class="row">													
		<div class="col-md-12">
			<h3>ID of Movie:</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<textarea name = "Review_id"></textarea>
		</div>
		<div class="col-md-4">
			<h4>e.g <I>111111</I></h4>
		</div>
	</div>
													<?php
													}
													// must be a numberic
													?>
	<div class="row">
		<div class="col-md-12">
			<h3>Rating:</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<textarea name = "Review_rating"></textarea>
		</div>
		<div class="col-md-4">
			<h4>In range of <I>0 - 5</I></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Comment:</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<textarea id="movie-comment" name = "Review_comment"></textarea>
		</div>
		<div class="col-md-8">
			<h4>Note: the comment cannot have more than 500 characters!</h4>
		</div>
	</div>
	<div class="row">
		<input type = "submit" name = "submit_review" value = "submit movie comments">
	</div>
	</form>
	<div class="row">
		<h4>
<?php
										if($_POST['submit_review']){
											$name = $_POST['Review_name'];
											$name = trim($name);
											$ID = $_GET['Movie_id'];
											$ID = trim($ID);
											if(empty($ID)){
												$noInputMovieID = true;
											}
											else{
												$noInputMovieID = false;
											}
											if($noInputMovieID){
												$ID = $_POST['Review_id'];	
											}
											$time = "'" . Date("Y-m-d H:i:s") . "'";
											$rating = $_POST['Review_rating'];
											$rating = trim($rating);
											
											$comments = $_POST['Review_comment'];
											$test = trim($comments);
											$badinput = false;
											if(empty($name)){
												echo "Please specify your name!";
												exit(0);
											}
											else{
												$name = "'" . $name . "'";
											}
											if($noInputMovieID && empty($ID)){
												echo "Please specify movie ID!";
												exit(0);
											}
											if(empty($rating)){
												echo "Please specify rating!";
												exit(0);
											}
											else if(!is_numeric($rating)){
												echo "Rating must be a numeric number!";
												exit(0);
											}
											else if($rating > 5){
												echo "Rating cannot be more than 5";
												exit(0);
											}
											if(empty($test)){
												echo "Please give comments!";
												exit(0);
											}
											else{
												$comments = "'" . $comments . "'";
											}
											if(!$badinput){
												$add = "insert into Review values(" . $name . ", " . $time . ", " . $ID . "," . $rating . "," . $comments . ");";
												// echo $add;
												mysql_query($add, $db_connection);
												// $affected = mysql_affected_rows($db_connection);		
												// print "Total affected rows: $affected<br>";
												if(mysql_errno($db_connection) == 0){
													$noError = true;
												}
												else{
													$noError = false;
												}
												if($noError){
													echo "Comment successful!";
												}
												else{
													echo "Comment error!";
												}
											}
										}
										?>
		</h4>
	</div>
	</div>
</div>								
<?php
mysql_close($db_connection);
page_foot();
?>