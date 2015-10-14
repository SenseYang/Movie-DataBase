<!--browse2.php, for movie information-->
<?php
require_once('facilities.php');
page_head('Movie Info');
$db_connection = getConnection();
?>
<!--basic movie informations-->
<h1>Movie Information<br></h1>
<?php
$movieID = $_GET['movieID'];
$movieInfoQuery = "select * from Movie where id = " . $movieID . ";";
$movieInfoResult = mysql_query($movieInfoQuery, $db_connection);
$movieInfo = mysql_fetch_row($movieInfoResult);
print "<blockquote><font size = 4>";
print "<B>Name: </B>" . $movieInfo[1] . "<br>";
print "<B>Year: </B>" . $movieInfo[2] . "<br>";
print "<B>Rating: </B>" . $movieInfo[3] . "<br>";
print "<B>Company: </B>" . $movieInfo[4] . "<br>";
print "</font></blockquote>";
?>
<!--add actor/actress link-->
<h1>Actor/Actress:<br></h1>
<blockquote>
<font size = 4>
<?php
$getActorQuery = "select aid, role from MovieActor where mid = " . $movieID . ";";
$actorIDResult = mysql_query($getActorQuery, $db_connection);
while($actorID = mysql_fetch_row($actorIDResult)){
	$getActorNameQuery = "select last, first from Actor where id =" . $actorID[0] . ";";
	$getActorNameResult = mysql_query($getActorNameQuery, $db_connection);
	$getActorName = mysql_fetch_row($getActorNameResult);
	$link = hyperlink(ACTOR, 'actorID', $actorID[0], $getActorName[1] . " " . $getActorName[0]);
	print $link;
	print ", Role: " . $actorID[1] . "<br>";
}
?>
</font>
</blockquote>
<!--add director link-->
<h1>Director:<br></h1>
<blockquote>
<font size = 4>
<?php
$getDirectorQuery = "select did from MovieDirector where mid = " . $movieID . ";";
$directorIDResult = mysql_query($getDirectorQuery, $db_connection);
while($directorID = mysql_fetch_row($directorIDResult)){
	$getDirectorNameQuery = "select last, first from Director where id =" . $directorID[0] . ";";
	$getDirectorNameResult = mysql_query($getDirectorNameQuery, $db_connection);
	$getDirectorName = mysql_fetch_row($getDirectorNameResult);
	$link = hyperlink(DIRECTOR_INFO, 'directorID', $directorID[0], $getDirectorName[1] . " " . $getDirectorName[0]);
	print $link;
	print "<br>";
}
?>
</font>
</blockquote>
<!--ratings and comments-->
<h1>Ratings and comments<br></h1>
<blockquote>
<font size = 4>
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


<!--show all user comments-->
<I><B>Comments:</B></I>
<br>
<blockquote>
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
<B><I>Name:</I></B>
<?php
	print $commentRow[0] . str_repeat("&nbsp", 5);
?>
<B><I>Time:</I></B>
<?php
	print $commentRow[1] . str_repeat("&nbsp", 5);
?>
<B><I>Rating:</I></B>
<?php
	print $commentRow[2] . "<br>";
?>
<B><I>Comment:<br></I></B>

<?php
	print "<blockquote>";
	print $commentRow[3] . "<br>";
	print "</blockquote>";
	}
	
	else{
		print "None<br>";
		break;
	}
}
?>

</blockquote>
</font>
</blockquote>
<form method = "POST" action = "<?php echo MOVIE_COMMENT.'?Movie_id=' . $movieID;?>">
<input type = "submit" value = "Add Your Comment">
</form>
<?php
mysql_close($db_connection);
page_foot();
?>
