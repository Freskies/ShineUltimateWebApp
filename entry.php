<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

session_start();

//

if (!isset($_SESSION['user']))
	header('Location: index.php');

require_once 'Libraries/Connection.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title>Shine</title>
	<link rel="stylesheet"
		  href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
		  crossorigin="anonymous">
</head>
<body>
<div class="container">
	<h1>Welcome <?php echo $_SESSION['user'] ?></h1>
	<a href="logout.php">logout</a>
</div>
</body>
