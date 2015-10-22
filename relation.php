										<?php
										require_once('facilities.php');
										page_head('Add Relation');
										$db_connection = getConnection();
										?>
<form method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Add Relationships</h2>
		</div>
	</div>
	<div class="container">	
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
					<div class="row">
						<h4><input type = "radio" name = "Ctype" value = "actor" checked>Actor</h4>
					</div>
				</div>
				<div class="col-md-11">
					<div class="row">
						<div class="col-md-2">
							<h4>Actor ID<sup>*</sup>:</h4> 
						</div>
						<div class="col-md-6">
							<textarea name = "Actor_id"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<h4>Role in the movie<sup>*</sup>:</h4>
						</div>
						<div class="col-md-6">
							<textarea name = "Actor_role"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--radio box for director-->
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-1">
					<div class="row">
						<h4><input type = "radio" name = "Ctype" value = "director">Director</h4>
					</div>
				</div>
				<div class="col-md-11">
					<div class="row">
						<div class="col-md-2">
							<h4>Director ID<sup>*</sup>:</h4>
						</div>
						<div class="col-md-6">
							<textarea name = "Director_id"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<h4>Movie ID<sup>*</sup>:</h4>
		</div>
		<div class="col-md-6">
			<textarea name = "Movie_id"></textarea>
		</div>
	</div>
	<div class="row">
		<input type = "submit" name = "submit_relation" value = "Submit Actor/Director and Movie Relations">
	</div>
</form>
	<div class="row">
		<h4>

										<?php
										if($_POST['submit_relation']){
											$ctype = $_POST['Ctype'];
											$movie_id = $_POST['Movie_id'];
											$badinput = false;
											$isActor = true;
											$msg = "";
											if($ctype == "actor"){
												$actorid = $_POST['Actor_id'];
												$actorid = trim($actorid);
												$actorrole = $_POST['Actor_role'];
												$isActor = true;
												if(empty($actorid)){
													echo "Please specify the actor's ID!<br>";
													exit(0);
												}
												else{// if no such actor exist
													$select = "select * from Actor where id = "	. $actorid . ";";
													mysql_query($select, $db_connection);
													$affect = mysql_affected_rows($db_connection);
													if($affect == 0){
														$msg .= "No actor with ID: " . $actorid . " is found<br>";
														echo $msg;
														exit(0);
													}
												}
												if(empty($actorrole)){
													echo "Please specify the actor's role in the movie!<br>";
													exit(0);
												}
												else{
													$actorrole = "'" . $actorrole . "'";
												}
											}
											
											if($ctype == "director" ){
												$directorid = $_POST['Director_id'];
												$directorid = trim($directorid);
												$isActor = false;
												if(empty($directorid)){
													echo "Please specify the director's ID!<br>";
													exit(0);
												}
												else{// if no such director exist
													$select = "select * from director where id = "	. $directorid . ";";
													mysql_query($select, $db_connection);
													$affect = mysql_affected_rows($db_connection);
													if($affect == 0){
														$msg .= "No director with ID: " . $directorid . " is found<br>";
														echo $msg;
														exit(0);
													}
												}
											}
											if(empty($movie_id)){
												echo "Please specify the movie's ID!<br>";
												exit(0);
											}
											else{
												$select = "select * from Movie where id = "	. $movie_id . ";";
												mysql_query($select, $db_connection);
												$affect = mysql_affected_rows($db_connection);
												if($affect == 0){
													$msg .= "No movie with ID: " . $movieID . " is found<br>";
													echo $msg;
													exit(0);
												}
											}
											if(!$badinput){
												$add = "insert into ";
												if($isActor){
													$add = $add . "MovieActor" . " values(" . $movie_id . ", " . $actorid . ", " . $actorrole . ");";
												}
												else{
													$add = $add . "MovieDirector" . " values(" . $movie_id . ", " . $directorid . ");";
												}
												mysql_query($add, $db_connection);
												// $affected = mysql_affected_rows($db_connection);		
												// print "Total affected rows: $affected<br>";
												if(mysql_errno($db_connection) == 0){
													$noError = true;
												}
												else{
													$noError = false;
												}
												if($noError){
													echo "Relation construction successful!<br>";
												}
												else{
													echo "Relation already existed<br>";
												}
											}
										}
										?>
		</h4>
	</div>
</div>
										<?php
										mysql_close($db_connection);
										page_foot();
										?>
