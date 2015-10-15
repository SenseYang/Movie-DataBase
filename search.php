<?php
require_once('facilities.php');
page_head('Search');
$db_connection = getConnection();
?>
<form method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>">
<blockquote>
	<p><h2>Search Page</h2><br></p>
		<textarea name = "searchKey" rows = 1 cols = 50></textarea>
		<input type = "submit" name = "searchKeySubmit" value = "submit"><br>
	e.g <I>Jon Smith</I> or <I>The Titanic</I><br>
<?php
$badinput = false;
if($_POST['searchKeySubmit']){
	$searchKey = $_POST['searchKey'];
	if(empty($searchKey)){
?>
		<p>Please Specify Any Searchkey!</p>
<?php
		$badinput = true;
	}
	// split the string into segments
	else{
		$searchKeyArray = preg_split("/\s/", $searchKey);
	}
	if(!$badinput){
		$noResult = true;
		$arraySize = count($searchKeyArray);
		$actorQuery = "select id, last, first from Actor where concat(first, ' ', last) like " . "'%" . $searchKeyArray[0] . "%' ";
		for($i = 1; $i < $arraySize; $i++){
			$actorQuery .= " and concat(first, ' ', last) like ";
			$actorQuery .= "'%" . $searchKeyArray[$i] . "%'";
		}
		$actorQuery .= ";";
		$result = mysql_query($actorQuery, $db_connection);
		$row = mysql_fetch_row($result);
		if($row){
			$noResult = false;
?>
			<table id='searchResult'>
			<tr><td><h2>Actors:</h2></td></tr>
<?php
			do{
				$link = hyperlink(ACTOR, 'actorID', $row[0], $row[2] . " " . $row[1]);
?>
			<tr><td><?php print $link?></td></tr>
<?php
				$row = mysql_fetch_row($result);
			}while($row);
?>
			</table>
<?php
		}
		// search in director, in page browse3, variable: directorID
		$directorQuery = "select id, last, first from Director where concat(first, ' ', last) like '%" . $searchKeyArray[0] . "%' ";
		for($i = 1; $i < $arraySize; $i++){
			$directorQuery .= " and concat(first, ' ', last) like ";
			$directorQuery .= "'%" . $searchKeyArray[$i] . "%'";
		}
		$directorQuery .= ";";
		$result = mysql_query($directorQuery, $db_connection);
		$row = mysql_fetch_row($result);
		if($row){
?>
			<table id='searchResult'>
			<tr><td><h2>Directors:</h2></td></tr>
<?php
			$noResult = false;
			do{
				$link = hyperlink(DIRECTOR_INFO, 'directorID', $row[0], $row[2] . " " . $row[1]);
?>
			<tr><td><?php print $link?></td></tr>
<?php
				// print $link;
				// print "<br>";	
				$row = mysql_fetch_row($result);		
			}while($row);
?>
			</table>
<?php
		}
		// search in title, variable: movieID
		$movieQuery = "select id, title, year from Movie where title like '%" . $searchKey . "%';";
		$result = mysql_query($movieQuery, $db_connection);
		$row = mysql_fetch_row($result);
		if($row){
			$noResult = false;
?>
			<table id='searchResult'>
			<tr><td><h2>Movies:</h2></td></tr>
<?php
			do{
				$link = hyperlink(MOVIE_INFO, 'movieID', $row[0], $row[1]. " (" .$row[2].")");
?>
				<tr><td><?php print $link?></td></tr>
<?php
				$row = mysql_fetch_row($result);
			}while($row);
?>
			</table>
<?php
		}
		if($noResult){
?> 
		<p>No results found!</p><br>
<?
		}
		else{
?>
<?
		}
	}
}
?>
</blockquote>
<?php
mysql_close($db_connection);
page_foot();
?>
