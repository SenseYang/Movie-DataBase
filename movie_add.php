<!--This page is used to add Movie information-->
										<?php
										require_once('facilities.php');
										page_head('Add Movie Info');
										$db_connection = getConnection();
										?>
<div class="container">
	<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
	<div class="row">
		<div class="col-md-12">
			<h2>Add Movie Information</h2>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>Movie ID<sup>*</sup>:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea class="searchtext" name = "Movie_id"></textarea>
			</div>
			<div class="col-md-6">
			<h4>Note: Movie ID cannot be <I>NULL</I>!</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Movie title<sup>*</sup>:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea class="searchtext" name = "Movie_title"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>The Titanic</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Year:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea class="searchtext" name = "Movie_year"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>1997</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Rating:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea class="searchtext" name = "Movie_rating"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>PG-13</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Company:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea class="searchtext" name = "Movie_company"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>Drama Film</I></h4>
			</div>
		</div>
		<div class="row">
			<input type = "submit" name = "submit_Movie" value = "submit actor/director info">
		</div>
		</form>
		<div class="row">
			<h4>
										<?php
										if($_POST['submit_Movie']){
											// first see if the ID is empty or not
											$movie_id = $_POST['Movie_id'];
											$movie_id = trim($movie_id);
											$movie_title = $_POST['Movie_title'];
											$title_test = trim($movie_title);
											$movie_year = $_POST['Movie_year'];
											$movie_year = trim($movie_year);
											$movie_rating = $_POST['Movie_rating'];
											$movie_rating = trim($movie_rating);
											$movie_company = $_POST['Movie_company'];
											$movie_company = trim($movie_company);
											$badinput = false;
											if(empty($movie_id)){
												echo "Please specify movie ID!";
												$badinput = true;
											}
											else{
												$read = "select * from Movie where id = " . $movie_id . ";";
												mysql_query($read, $db_connection);
												$affected = mysql_affected_rows($db_connection);
												if($affected){
													echo "Movie with ID = ". $movie_id . "already exists!";
													exit(0);
												}
											}
											if(empty($title_test)){
												echo "Please specify movie title!";
												exit(0);
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
		Movie info added!
											<?php
												if(mysql_errno($db_connection)){
													$select = "select * from Movie where id = " . $movie_id . ";";
													mysql_query($select, $db_connection);
													$affected = mysql_affected_rows($db_connection);
													if($affected > 0) echo "Duplicate Movie ID: " . $movie_id . " already exists.";
													else echo "Invalid input";
												}
												
											}	
										}
										mysql_close($db_connection);
										?>
			</h4>												
		</div>
	</div>
</div>
										<?php
										page_foot();
										?>