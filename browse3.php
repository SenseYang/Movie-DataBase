<!--browse3.php-->
<!--To browse director information, show links to the movies that he directs-->
<!--variable: $directorID, using $_GET['something'] to capture the h3eter-->
										<?php
										require_once('facilities.php');
										page_head('Director Info');
										$db_connection = getConnection();
										?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Director Information</h2>
		</div>
	</div>

										<?php
										$directorID = $_GET['directorID'];
										$query = "select * from Director where id = " . $directorID;
										$result = mysql_query($query, $db_connection);
										$row = mysql_fetch_row($result);
										?>
	<div class="row">
		<div class="col-md-2">
			<h3>ID: </h3>
		</div>
		<div class="col-md-10">
			<div class="h3"><?php echo $row[0]?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<h3>Name: </h3>
		</div>
		<div class="col-md-10">
			<div class="h3"><?php echo $row[2] . " " . $row[1]?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<h3>Date of birth:</h3>
		</div>
		<div class="col-md-9">
			<div class="h3"><?php echo $row[3]?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<h3>Date of death: </h3>
		</div>
		<div class="col-md-9">
										<div class="h3"><?
										if(empty($row[5])){
											print "0000-00-00";
										}
										else
											print $row[5];
										?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Directed Movies:</h3>
		</div>
	</div>
										<?php
										$movieQ = "select mid from MovieDirector where did = " . $directorID . ";";
										$result = mysql_query($movieQ, $db_connection);
										while($row = mysql_fetch_row($result)){
											// get link name
											$movieNameQuery  = "select title, year from Movie where id = " . $row[0] . ";";
											$nameResult = mysql_query($movieNameQuery, $db_connection);
											$name = mysql_fetch_row($nameResult);
											$link = hyperlink(MOVIE_INFO, 'movieID', $row[0], $name[0] . " (" . $name[1] . ")");
										?>
	<div class="row">
		<div class="col-md-12">
			<h4><?php echo $link;?></h4>
		</div>
	</div>
<?php
}
?>
</div>
<?php
mysql_close($db_connection);
page_foot();
?>