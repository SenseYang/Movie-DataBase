<!--This page is used to add Movie information-->
<?php
require_once('facilities.php');
page_head('Add Movie Info');
$db_connection = getConnection();
?>
<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">

Movie ID:<br>
<textarea name = "Movie_id" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>Note: Movie ID cannot be <I>NULL</I>!<br>

Movie title:<br>
<textarea name = "Movie_title" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>The Titanic</I><br>

Year:<br>
<textarea name = "Movie_year" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>1997</I><br>

Rating:<br>
<textarea name = "Movie_rating" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>PG-13</I><br>

Company:<br>
<textarea name = "Movie_company" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>Drama Film</I><br>

<input type = "submit" name = "submit_Movie" value = "submit actor/director info"> <br><br></blockquote>
</form>
<?php
if($_POST['submit_Movie']){
	// first see if the ID is empty or not
	$movie_id = $_POST['Movie_id'];
	$movie_title = $_POST['Movie_title'];
	$movie_year = $_POST['Movie_year'];
	$movie_rating = $_POST['Movie_rating'];
	$movie_company = $_POST['Movie_company'];
	$badinput = false;
	if(!isset($movie_id)){
		echo "Please specify movie ID!<br>";
		$badinput = true;
	}
	if(!isset($movie_title)){
		echo "Please specify movie title!<br>";
		$badinput = true;
	}
	else{
		$movie_title = "'" . $movie_title . "'";
	}
	if(empty($movie_year)){
		$movie_year = "NULL";
	}
	if(empty($movie_rating)){
		$movie_rating = "NULL";
	}
	else{
		$movie_rating = "'" . $movie_rating . "'";
	}
	if(empty($movie_company)){
		$movie_company = "NULL";
	}
	else{
		$movie_company = "'" . $movie_company . "'";
	}
	if(!$badinput){
		$add = "insert into Movie values(" . $movie_id . ", " . $movie_title . ", " . $movie_year . "," . $movie_rating . "," . $movie_company . ");";
		//echo $add;
		mysql_query($add, $db_connection);
		$affected = mysql_affected_rows($db_connection);
		if($affected >= 0)
	?>
		<p>Movie info added</p>
		<p>ID: <?php echo "$movie_id"; ?><br></p>
		<p>Movie Title: <?php echo "$movie_title"; ?><br></p>
		<p>Movie Year: <?php echo "$movie_year"; ?><br></p>
		<p>Movie Rating: <?php echo "$movie_rating"; ?><br></p>
		<p>Movie Company: <?php echo "$movie_company"; ?><br></p>
	<?php
		if(mysql_errno($db_connection)){
			$select = "select * from Movie where id = " . $movie_id . ";";
			mysql_query($select, $db_connection);
			$affected = mysql_affected_rows($db_connection);
			if($affected > 0) echo "Duplicate Movie ID: " . $movie_id . " already exists.<br>";
			else echo "Invalid input<br>";
		}
		
	}	
}
mysql_close($db_connection);
page_foot();
?>