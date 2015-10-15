<?php
/**
 * CSS decoration files
 */
header( 'Content-Type: text/css' );
?>
body {
	background-color:lightgray;
	font-family: Arial Black;
	font-weight: 300;
	font-size: 14px;
	background-color:lightgrey
	line-height: 18px;
	width: 1200px;
	margin: 0 auto;
	color: #424242;
}

h1, h2, h3, h4, h5, h6 {
	font-family: Arial Black;
}

header {
	margin-bottom: 40px;
}

header h1 {
	font-family: Impact;
	font-size: 50x;
	font-weight: bold;
	color: #424242;
	width: 400px;
	float: left;
}

small{
	font-family: Arial Black;
}
nav ul {
	font-family: Impact;
	width: 600px;
	float: right;
	font-size: 14px;
}

nav li{
	display:inline;
}
nav li a, nav li a:visited {
	color: #556270;
	font-size: 16px;
}

p, div {
	padding: 10px;
	margin: 20px;
	clear: both;
}

table#searchResult{
	float:left;
	width: 33%;
}
sup{
	color: red;
}


<?php
/**
 * End of file...
 */