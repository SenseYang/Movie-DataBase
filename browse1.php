<!--browse1.php-->
<!--To browse actor information, show links to the movies that the actor was in-->
<!--variable: $actorID, using $_GET['something'] to capture the parameter-->
														<?php
														require_once('facilities.php');
														page_head('Actor Information');
														$db_connection = getConnection();
														?>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h2>Actor Information</h2>
		</div>
	</div>
														<?php
														$actorID = $_GET['actorID'];
														$query = "select * from Actor where id = " . $actorID;
														$result = mysql_query($query, $db_connection);
														$row = mysql_fetch_row($result);
														?>
    <div class="row">
		<div class="col-md-6">
			<B>ID: </B><?php echo $row[0]?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<B>Name: </B><?php echo $row[2] . " " . $row[1] ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<B>Sex: </B><?php echo $row[3]?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<B>Date of birth: </B><?php echo $row[4]?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<B>Date of death: </B>
														<?php
														if(empty($row[5])){
															print "0000-00-00";
														}
														else
															print $row[5];
														?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h2>Acted in Movies:</h2>
		</div>
	</div>
														<?php
														$movieQ = "select mid from MovieActor where aid = " . $actorID . ";";
														$result = mysql_query($movieQ, $db_connection);
														while($row = mysql_fetch_row($result)){
															$movieNameQuery  = "select title, year from Movie where id = " . $row[0] . ";";
															$nameResult = mysql_query($movieNameQuery, $db_connection);
															$name = mysql_fetch_row($nameResult);
															$link = hyperlink(MOVIE_INFO, 'movieID', $row[0], $name[0] . " (" . $name[1].")");
														?>
	<div class="row">
		<div class="col-md-6">
														<?php
															echo $link;
														}
														?>
		</div>
	</div>
</div>
<?php
mysql_close($db_connection);
page_foot();
?>
