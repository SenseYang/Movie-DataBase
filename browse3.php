<!--browse3.php-->
<!--To browse director information, show links to the movies that he directs-->
<!--variable: $directorID, using $_GET['something'] to capture the parameter-->
<?php
require_once('facilities.php');
page_head('Director Info');
$db_connection = getConnection();
?>
<h1>Director Information<br></h1>
<?php
// assume that the ID of actor is known
$directorID = $_GET['directorID'];
$query = "select * from Director where id = " . $directorID;
$result = mysql_query($query, $db_connection);
$row = mysql_fetch_row($result);
// print ID
print "<blockquote><font size = 4>";
print "<B>ID: </B>";
print $row[0] . "<br>";
print "<B>Name: </B>";
print $row[2] . " " . $row[1] . "<br>";
print "<B>Sex: </B>";
print $row[3] . "<br>";
print "<B>Date of birth: </B>";
print $row[4] . "<br>";
print "<B>Date of death: </B>";
if(empty($row[5])){
	print "0000-00-00<br>";
}
else
	print $row[5] . "<br>";
print "</font></blockquote>";
// Then get related movie information
print "<h1>Directed Movies:<br></h1>";
print "<blockquote><font size = 4>";
$movieQ = "select mid from MovieDirector where did = " . $directorID . ";";
$result = mysql_query($movieQ, $db_connection);
while($row = mysql_fetch_row($result)){
	// get link name
	$movieNameQuery  = "select title, year from Movie where id = " . $row[0] . ";";
	$nameResult = mysql_query($movieNameQuery, $db_connection);
	$name = mysql_fetch_row($nameResult);
	$link = hyperlink(MOVIE_INFO, 'movieID', $row[0], $name[0] . " (" . $name[1] . ")");
?>
	<p><?php echo $link;?></p>
<?php
}
print "</font></blockquote>";

mysql_close($db_connection);
page_foot();
?>