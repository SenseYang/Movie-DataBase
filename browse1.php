<!--browse1.php-->
<!--To browse actor information, show links to the movies that the actor was in-->
<!--variable: $actorID, using $_GET['something'] to capture the parameter-->
<?php
require_once('facilities.php');
page_head('Actor Information');
$db_connection = getConnection();
?>

<h1>Actor Information<br></h1>
<?php
// assume that the ID of actor is known
$actorID = $_GET['actorID'];
$query = "select * from Actor where id = " . $actorID;
$result = mysql_query($query, $db_connection);
$row = mysql_fetch_row($result);
// print ID
print "<blockquote><font size = 4>";
print '<B>ID: </B>'. $row[0] . '<br>';
print '<B>Name: </B>'. $row[2] . " " . $row[1] . '<br>';
print '<B>Sex: </B>'. $row[3] . '<br>';
print '<B>Date of birth: </B>'. $row[4] . '<br>';
print '<B>Date of death: </B>';
if(empty($row[5])){
	print "0000-00-00<br>";
}
else
	print $row[5] . "<br>";

print "</font></blockquote>";
// Then get related movie information
print "<h1>Acted in Movies:<br></h1>";
print "<blockquote><font size = 4>";
$movieQ = "select mid from MovieActor where aid = " . $actorID . ";";
$result = mysql_query($movieQ, $db_connection);
while($row = mysql_fetch_row($result)){
	// get link name
	$movieNameQuery  = "select title, year from Movie where id = " . $row[0] . ";";
	$nameResult = mysql_query($movieNameQuery, $db_connection);
	$name = mysql_fetch_row($nameResult);
	$link = hyperlink(MOVIE_INFO, 'movieID', $row[0], $name[0] . " (" . $name[1].")");
			
	$link = "<B><I><a href=\"browse2.php?movieID=" . $row[0] . "\">" . $name[0] . " (" . $name[1] . ")" . "</a></I></B><br>";
	echo $link;
}
print "</font></blockquote>";

mysql_close($db_connection);
page_foot();
?>
