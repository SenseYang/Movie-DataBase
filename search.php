										<?php
										require_once('facilities.php');
										page_head('Search');
										$db_connection = getConnection();
										?>
<form method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Search Page</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<textarea class="searchtext" name = "searchKey"></textarea>
		</div>
		<div class="col-md-6">
			<div class="searchButton" >
				<input type = "submit" name = "searchKeySubmit" value = "submit">
			</div>
		</div>			
	</div>
	<div class="row">
		<div class="col-md-12">e.g <I>Jon Smith</I> or <I>The Titanic</I>
		</div>
	</div>
</div>
										<?php
										$badinput = false;
										if($_POST['searchKeySubmit']){
											$searchKey = $_POST['searchKey'];
											if(empty($searchKey)){
										?>
<div class="container">
	<div class="row">Please Specify Any Searchkey!</div>
</div>
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
<div class="container">
	<div class="col-md-4">
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
	</div>
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
	<div class="col-md-4">
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
	</div>
									<?php
											}
											// search in title, variable: movieID
											$movieQuery = "select id, title, year from Movie where title like '%" . $searchKey . "%';";
											$result = mysql_query($movieQuery, $db_connection);
											$row = mysql_fetch_row($result);
											if($row){
												$noResult = false;
									?>
	<div class="col-md-4">
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
	</div>
									<?php
											}
											if($noResult){
									?> 
	<div class="row">No results found!</div>
									<?
											}
											else{
									?>
									<?
											}
										}
									}
									?>
</div>
<?php
mysql_close($db_connection);
page_foot();
?>
