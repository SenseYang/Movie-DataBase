																				<?php
																				require_once('facilities.php');
																				page_head('Movie Info');
																				$db_connection = getConnection();
																				?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Movie Information</h2>
		</div>
	</div>
																				<?php
																				$movieID = $_GET['movieID'];
																				$movieInfoQuery = "select * from Movie where id = " . $movieID . ";";
																				$movieInfoResult = mysql_query($movieInfoQuery, $db_connection);
																				$movieInfo = mysql_fetch_row($movieInfoResult);
																				?>
	<div class="row">
		<div class="col-md-2">
			<h3>Name:</h3>														
		</div>
		<div class="col-md-10">
			<h3><?php echo $movieInfo[1]?></h3>													
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<h3>Year:</h3>														
		</div>
		<div class="col-md-10">
			<h3><?php echo $movieInfo[2]?></h3>												
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<h3>Rating:</h3>													
		</div>
		<div class="col-md-10">
			<h3><?php echo $movieInfo[3]?></h3>											
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<h3>Company:</h3>													
		</div>
		<div class="col-md-10">
			<h3><?php echo $movieInfo[4]?></h3>								
		</div>
	</div>		
<!--add actor/actress link-->
	<div class="row">
		<div class="col-md-2">
			<h3>Actor/Actress:</h3>
		</div>
	</div>
																				<?php
																				$getActorQuery = "select aid, role from MovieActor where mid = " . $movieID . ";";
																				$actorIDResult = mysql_query($getActorQuery, $db_connection);
																				while($actorID = mysql_fetch_row($actorIDResult)){
																					$getActorNameQuery = "select last, first from Actor where id =" . $actorID[0] . ";";
																					$getActorNameResult = mysql_query($getActorNameQuery, $db_connection);
																					$getActorName = mysql_fetch_row($getActorNameResult);
																					$link = hyperlink(ACTOR, 'actorID', $actorID[0], $getActorName[1] . " " . $getActorName[0]) . ", Role: " . $actorID[1];	
																				?>
	<div class="row">
		<div class="col-md-12">
																				<?php echo $link;
																				?>
		</div>
	</div>
																				<?php
																				}																			
																				?>
<!--add director link-->
	<div class="row">
		<div class="col-md-12">
			<h3>Director:</h3>
		</div>
	</div>
																				<?php
																				$getDirectorQuery = "select did from MovieDirector where mid = " . $movieID . ";";
																				$directorIDResult = mysql_query($getDirectorQuery, $db_connection);
																				while($directorID = mysql_fetch_row($directorIDResult)){
																					$getDirectorNameQuery = "select last, first from Director where id =" . $directorID[0] . ";";
																					$getDirectorNameResult = mysql_query($getDirectorNameQuery, $db_connection);
																					$getDirectorName = mysql_fetch_row($getDirectorNameResult);
																				?>
	<div class="row">
		<div class="col-md-12">
																				<?php
																					$link = hyperlink(DIRECTOR_INFO, 'directorID', $directorID[0], $getDirectorName[1] . " " . $getDirectorName[0]);
																					print $link;
																				?>
		</div>
	</div>
																				<?
																				}
																				?>
<!--ratings and comments-->
	<div class="row">
		<div class="col-md-12">
			<h1>Ratings and comments</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<I><B>Average rating</B></I>
																				<?php
																				// first calculate the average rating from database 
																				$ratingQuery = "select tot_r/ct, ct
																								from(
																									select sum(rating) as tot_r, count(rating) as ct
																									from Review
																									where mid = " . $movieID . 
																								") as T;";
																				$ratingResult = mysql_query($ratingQuery, $db_connection);
																				$ratingRow = mysql_fetch_row($ratingResult);
																				$rating = $ratingRow[0];
																				if(empty($rating)){
																					$rating = "Too few people give rating on this movie";
																				}
																				print "(total " . $ratingRow[1] . " ratings): " . $rating . "<br>";
																				?>
		</div>
	</div>
</div>
<!--show all user comments-->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<I><B>Comments:</B></I>
		</div>
	</div>

																				<?php
																				$noComment = false;
																				$commentQuery = "select name, time, rating, comment
																								from Review
																								where mid = " . $movieID . ";";
																				$commentResult = mysql_query($commentQuery, $db_connection);
																				while($commentRow = mysql_fetch_row($commentResult)){
																					if(empty($commentRow[0])){
																						$noComment = true;
																					}
																						if(!$noComment){
																					
																				?>	
	<div class="row">
		<div class="col-md-12">
			<I><B>Name:</B></I>
																				<?php
																					print $commentRow[0];
																				?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<I><B>Time:</B></I>																				
																				<?php
																					print $commentRow[1];
																				?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<I><B>Rating:</B></I>
																				<?php
																					print $commentRow[2];
																				?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<I><B>Comment:</B></I>

																				<?php																					
																					print $commentRow[3];																					
																					}																					
																					else{
																						print "None<br>";
																						break;
																					}
																				}
																				?>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<form method = "POST" action = "<?php echo MOVIE_COMMENT.'?Movie_id=' . $movieID;?>">
		<input type = "submit" value = "Add Your Comment">
		</form>
	</div>
</div>
																				<?php
																				mysql_close($db_connection);
																				page_foot();
																				?>