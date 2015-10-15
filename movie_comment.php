<!--This page is used to add movie comments-->
<?php
require_once('facilities.php');
page_head('Movie Comment');
$db_connection = getConnection();
?>

	<blockquote>
		<p><h2>Movie Comment</h2></p>
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
		<p>
			Name:<br>
			<textarea name = "Review_name" rows = 1 cols = 20>
			</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>Skyfans</I><br>
			<!--time should not be a input value-->
			<!--if it is linked from movie info page, then it should not have movie id input box-->
			<?php
			if($noInputMovieID){
			?>
			ID of Movie:<br>
			<textarea name = "Review_id" rows = 1 cols = 20>
			</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>111111</I><br>
			<?php
			}
			// must be a numberic
			?>
			Rating:<br>
			<textarea name = "Review_rating" rows = 1 cols = 20>
			</textarea><?php echo str_repeat("&nbsp", 5);?>In range of <I>0 - 5</I><br>
			Comment:<br>
			<textarea name = "Review_comment" rows = 10 cols = 20>
			</textarea><?php echo str_repeat("&nbsp", 5);?>Note: the comment cannot have more than 500 characters!<br>

			<input type = "submit" name = "submit_review" value = "submit movie comments"><br>
		</p>
	</blockquote>
</form>
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
		echo "Please specify your name!<br>";
		exit(0);
	}
	else{
		$name = "'" . $name . "'";
	}
	if($noInputMovieID && empty($ID)){
		echo "Please specify movie ID!<br>";
		exit(0);
	}
	if(empty($rating)){
		echo "Please specify rating!<br>";
		exit(0);
	}
	else if(!is_numeric($rating)){
		echo "Rating must be a numeric number!<br>";
		exit(0);
	}
	else if($rating > 5){
		echo "Rating cannot be more than 5";
		exit(0);
	}
	if(empty($test)){
		echo "Please give comments!<br>";
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
			echo "Comment successful!<br>";
		}
		else{
			echo "Comment error!<br>";
		}
	}
}
?>
<?php
mysql_close($db_connection);
page_foot();
?>