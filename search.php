<?php
require_once('facilities.php');
page_head('Search');
$db_connection = getConnection();
?>
<h1>Search Page</h1><br>
<form method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>">
<blockquote>
Search:<br>
<textarea name = "searchKey" rows = 1 cols = 50>
</textarea>
<input type = "submit" name = "searchKeySubmit" value = "submit"><br>
e.g <I>Jon Smith</I> or <I>The Titanic</I>
</blockquote>
<?php

$badinput = false;
if($_POST['searchKeySubmit']){
	$searchKey = $_POST['searchKey'];
	if(empty($searchKey)){
		echo "Please specify search key<br>";
		$badinput = true;
	}
	// split search key into parts
	else{
		$searchKeyArray = preg_split("/\s/", $searchKey);
	}
	if(!$badinput){
		$noResult = true;
		$arraySize = count($searchKeyArray);
		$actorQuery = "select id, last, first from Actor where concat(first, ' ', last) like " . "'%" . $searchKeyArray[0] . "%' ";
		for($i = 1; $i < $arraySize; $i++){
			$actorQuery .= " and concat(first, last) like ";
			$actorQuery .= "'%" . $searchKeyArray[$i] . "%'";
		}
		$actorQuery .= ";";
		$result = mysql_query($actorQuery, $db_connection);
		$row = mysql_fetch_row($result);
		if($row){
			$noResult = false;
			print "<font size = 4>Actors:<br></font>";
			do{
				$link = hyperlink(ACTOR, 'actorID', $row[0], $row[2] . " " . $row[1]);
				print $link;
				print "<br>";	
				$row = mysql_fetch_row($result);
			}while($row);
		}
		// search in director, in page browse3, variable: directorID
		$directorQuery = "select id, last, first from Director where concat(first, last) like '%" . $searchKeyArray[0] . "%' ";
		for($i = 1; $i < $arraySize; $i++){
			$directorQuery .= " and concat(first, last) like ";
			$directorQuery .= "'%" . $searchKeyArray[$i] . "%'";
		}
		$directorQuery .= ";";
		$result = mysql_query($directorQuery, $db_connection);
		$row = mysql_fetch_row($result);
		if($row){
			$noResult = false;
			print "<font size = 4>Directors:<br></font>";
			do{
				$link = hyperlink(DIRECTOR_INFO, 'directorID', $row[0], $row[2] . " " . $row[1]);
				print $link;
				print "<br>";	
				$row = mysql_fetch_row($result);		
			}while($row); 
		}
		// search in title, variable: movieID
		$movieQuery = "select id, title, year from Movie where title like '%" . $searchKey . "%';";
		$result = mysql_query($movieQuery, $db_connection);
		print "<br>";
		$row = mysql_fetch_row($result);
		if($row){
			$noResult = false;
			print "<font size = 4>Movies:<br></font>";
			do{
				$link = hyperlink(MOVIE_INFO, 'movieID', $row[0], $row[1]. " (" .$row[2].")");
				print $link;
				print "<br>";	
				$row = mysql_fetch_row($result);
			}while($row);
		}
		if($noResult){
?>
		<p>No results found!</p>
<?
		}
	}
}
mysql_close($db_connection);
page_foot();
?>
