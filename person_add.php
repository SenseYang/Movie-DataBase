<!--This page is used to add person information-->
										<?php
										require_once('facilities.php');
										page_head('Add Actor/Director Info');
										$db_connection = getConnection();
										?>
<div class="container">
<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
	<div class="row">
		<div class="col-md-12">
			<h2>Add Person Information</h2>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>ID<sup>*</sup>:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea name = "Actor_id"></textarea>
			</div>
			<div class="col-md-6">
				<h4>Note: ID cannot be <I>NULL</I>!</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Last Name:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea name = "Actor_last"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>Hanks</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>First Name:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea name = "Actor_first"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>Tom</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Sex:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea name = "Actor_sex"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>Male</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Date of birth:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea name = "Actor_dob"></textarea>
			</div>
			<div class="col-md-6">
				<h4>e.g <I>1956-07-09</I></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3>Date of death:</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<textarea name = "Actor_dod"></textarea>
			</div>
			<div class="col-md-6">
				<h4>If actor is still alive, then input <I>NULL</I></h4>
			</div>
		</div>
		<div class="row">
			<input type = "radio" name = "Ctype" value = "actor" checked>Actor
		</div>
		<div class="row">
			<input type = "radio" name = "Ctype" value = "director">Director
		</div>
		<div class="row">
			<div class="col-md-4">
				<input type = "submit" name = "submit_Actor" value = "submit actor/director info">
			</div>
		</div>
	</form>
		<div class="row">
			<div class="col-md-12">
				<h4>
											<?php
											if($_POST['submit_Actor']){
												$actor_id = $_POST['Actor_id'];
												$actor_id = trim($actor_id);
												$actor_last = $_POST['Actor_last'];
												$actor_last = trim($actor_last);
												$actor_first = $_POST['Actor_first'];
												$actor_first = trim($actor_first);
												$actor_sex = $_POST['Actor_sex'];
												$actor_sex = trim($actor_sex);
												$actor_dob = $_POST['Actor_dob'];
												$actor_dob = trim($actor_dob);
												$actor_dod = $_POST['Actor_dod'];
												$actor_dod = trim($actor_dod);
												$actor_type = $_POST['Ctype'];
												$badinput = false;
												if(empty($actor_id)){
													echo "Error: Please specify actor/director id!";
													exit(0);
												}
												else{
													$read = "select * from Actor where id = " . $actor_id;
													$who = ($actor_type == "actor") ? "Actor": "Director";
													mysql_query($read, $db_connection);
													$affected = mysql_affected_rows($db_connection);
													if($affected){
														echo $who . " with ID = " . $actor_id . " already exists!";
														exit(0);
													}
												}
												if(empty($actor_last)){
													echo "Error: Please specify actor/director lastname!";
													exit(0);
												}
												if(empty($actor_first)){
													echo "Error: Please specify actor/director firstname!";
													exit(0);
												}
												if(empty($actor_sex)){
													echo "Error: Please specify actor/director sex!<br>";
													exit(0);
												}
												if(empty($actor_dob) || $actor_dob == "NULL"){
													echo "Warning: character's date of birth unspecified; it will be set as NULL.";
													$actor_dob = "NULL";
												}
												else{
													$actor_dob = "'" . $actor_dob . "'";
												}
												if(empty($actor_dod) || $actor_dod == "NULL"){
													echo "Warning: character's date of death unspecified; it will be set as NULL.";
													$actor_dod = "NULL";
												}
												else{
													$actor_dod = "'" . $actor_dod . "'";
												}
												
												echo $badInput;
												if($badinput == false){
													if($actor_type == "actor"){
														$add = "insert into Actor values(" . $actor_id . ",  '" . $actor_last . " '" . ",  '" . $actor_first . " '" . ",  '" . $actor_sex . " '" . "," . $actor_dob . ", " . $actor_dod . ");";
													
													}
													else{
														$add = "insert into Director values(" . $actor_id . ",  '" . $actor_last . " '" . ",  '" . $actor_first . "' " . "," . $actor_dob . ", " . $actor_dod . ");";
													}
													//echo $add;
													mysql_query($add, $db_connection);
													$affected = mysql_affected_rows($db_connection);		
													if(mysql_errno($db_connection)){
														echo mysql_errno($db_connection) . ": " . mysql_error($db_connection);
													}
												}
											}
											mysql_close($db_connection);
											?>
				</h4>
			</div>
		</div>
	</div>
</div>
										<?php
										page_foot();
										?>