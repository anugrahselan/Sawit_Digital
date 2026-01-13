<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<style type="text/css">

::selection { background-color:
::-moz-selection { background-color:

body {
	background-color:
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color:
}

a {
	color:
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color:
	background-color: transparent;
	border-bottom: 1px solid
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color:
	border: 1px solid
	color:
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

	margin: 10px;
	border: 1px solid
	box-shadow: 0 0 8px
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>