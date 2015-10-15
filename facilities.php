<?php
define(ACTOR, 'browse1.php');
define(MOVIE_INFO, 'browse2.php');
define(DIRECTOR_INFO, 'browse3.php');
define(INDEX, 'index.php');
define(SEARCH, 'search.php');
define(MOVIE_ADD, 'movie_add.php');
define(MOVIE_COMMENT, 'movie_comment.php');
define(PERSON_ADD, 'person_add.php');
define(RELATION, 'relation.php');
define(CSS, 'css.php');
/*Create a page head for each page. $curPage is the name of current page.*/
function page_head($curPage){
?>
<!DOCTYPE html>
<html>
	<head>
		<title> My Movie Database_<?php echo $curPage?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>">
	</head>
		<header>
			<h1>My Movie Database<sub><i><small>by Sen Yang</small></i></sub></h1>
			<nav>
				<ul>
					<li><a href="<?php echo INDEX        ?>">Front Page   </a></li>|
					<li><a href="<?php echo SEARCH       ?>">Search       </a></li>|
					<li><a href="<?php echo MOVIE_ADD    ?>">Add Movie    </a></li>|
					<li><a href="<?php echo MOVIE_COMMENT?>">Add Comment  </a></li>|
					<li><a href="<?php echo PERSON_ADD   ?>">Add Person   </a></li>|
					<li><a href="<?php echo RELATION     ?>">Add Relation </a></li>
				</ul>
			</nav>
		</header>
<?php
}
function page_foot(){
?>
	</body>
</html>
<?php
}

/*
Get a Database connection using mysql_connect(). Remember to close after use.
*/
function getConnection(){
	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	if(!$db_connection) {
		$errmsg = mysql_error($db_connection);
		print "Connection failed: $errmsg <br>";
		exit(1);
	}
	else return $db_connection;
}
function url_for_id( $url, $paraname, $id ) {
	return "$url?$paraname=$id";
}
function hyperlink( $url, $paraname, $id, $text, $target = NULL ) {
	$a = '<I><a href="' . url_for_id( $url, $paraname, $id ) . '"';
	if ( $target )
		$a .= ' target="_blank"';
	$a .= ">$text</a></I>";
	return $a;
}
