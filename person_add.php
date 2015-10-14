<!--This page is used to add person information-->
<?php
require_once('facilities.php');
page_head('Add Actor/Director Info');
$db_connection = getConnection();
?>
<form method = "POST" action = "<?php echo $_SERVER['PHP_SELF'];?>">
<blockquote>
ID:<br>
<textarea name = "Actor_id" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>Note: ID cannot be <I>NULL</I>!<br>

Last Name:<br>
<textarea name = "Actor_last" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>Hanks</I><br>

First Name:<br>
<textarea name = "Actor_first" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>Tom</I><br>

Sex:<br>
<textarea name = "Actor_sex" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>Male</I><br>

Date of birth:<br>
<textarea name = "Actor_dob" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>e.g <I>1956-07-09</I><br>

Date of death:<br>
<textarea name = "Actor_dod" rows = 1 cols = 20>
</textarea><?php echo str_repeat("&nbsp", 5);?>If actor is still alive, then input <I>NULL</I>.<br>

<!--input type = radio-->
<input type = "radio" name = "Ctype" value = "actor" checked>Actor<br>
<input type = "radio" name = "Ctype" value = "director">Director<br>

<input type = "submit" name = "submit_Actor" value = "submit actor/director info"> <br><br>
</blockquote>
</form>
<?php
if($_POST['submit_Actor']){
	$actor_id = $_POST['Actor_id'];
	$actor_last = $_POST['Actor_last'];
	$actor_first = $_POST['Actor_first'];
	$actor_sex = $_POST['Actor_sex'];
	$actor_dob = $_POST['Actor_dob'];
	$actor_dod = $_POST['Actor_dod'];
	$actor_type = $_POST['Ctype'];
	$badinput = false;
	if(empty($actor_id)){
		echo "Error: Please specify actor/director id!<br>";
		$badinput = true;
	}
	if(empty($actor_last)){
		echo "Error: Please specify actor/director lastname!<br>";
		$badinput = true;
	}
	if(empty($actor_first)){
		echo "Error: Please specify actor/director firstname!<br>";
		$badinput = true;
	}
	if(empty($actor_sex)){
		echo "Error: Please specify actor/director sex!<br>";
		$badinput = true;
	}
	if(empty($actor_dob) || $actor_dob == "NULL"){
		echo "Warning: character's date of birth unspecified; it will be set as NULL.<br>";
		$actor_dob = "NULL";
	}
	else{
		$actor_dob = "'" . $actor_dob . "'";
	}
	if(empty($actor_dod) || $actor_dod == "NULL"){
		echo "Warning: character's date of death unspecified; it will be set as NULL.<br>";
		$actor_dod = "NULL";
	}
	else{
		$actor_dod = "'" . $actor_dod . "'";
	}
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
		print "Total affected rows: $affected<br>";
		if(mysql_errno($db_connection)){
			echo mysql_errno($db_connection) . ": " . mysql_error($db_connection) . "<br>";
		}
	}
}
mysql_close($db_connection);
page_foot();
?>