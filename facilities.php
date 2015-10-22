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
																						define(CSS, 'css/bootstrap.css');
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
	<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1 class="head-head">My Movie Database<sub><i><small>by Sen Yang</small></i></sub></h1>
				</div>
			</div>
			<div class="row">
				<nav class="col-md-8">
					<ul>
						<li><a href="<?php echo INDEX?>"><h4>Front Page|</h4></a></li>
						<li><a href="<?php echo SEARCH?>"><h4>Search|</h4></a></li>
						<li><a href="<?php echo MOVIE_ADD?>"><h4>Add Movie|</h4></a></li>
						<li><a href="<?php echo MOVIE_COMMENT?>"><h4>Add Comment|</h4></a></li>
						<li><a href="<?php echo PERSON_ADD?>"><h4>Add Person|</h4></a></li>
						<li><a href="<?php echo RELATION?>"><h4>Add Relation</h4></a></li>
					</ul>
				</nav>
				<div class="col-md-6"></div>
			</div>
	</div>
	</header>
	<body>
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
