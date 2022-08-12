<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

session_start();

// if the user already logged in, redirect to the main page
if (isset($_SESSION['user']))
	header('Location: entry.php');

// if the user try to log in, check the credentials
if (isset($_POST['username']) && isset($_POST['password']))
{
	require_once 'Libraries/Connection.php';
	$conn = new Connection('shine');
	$query = "SELECT password FROM users WHERE username = ?;";
	$result = $conn->execute($query, [$_POST["username"]]);
	if (password_verify($_POST["password"], $result[0]["password"] ?? ""))
	{
		$_SESSION['user'] = $_POST["username"];
		header('Location: entry.php');
	}
	else
		echo '<script>alert("Wrong credentials")</script>';
}
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
	<form action="index.php" method="post">
		<label for="username">Username</label><br>
		<input type="text" name="username" id="username" required><br>
		<label for="password">Password</label><br>
		<input type="password" name="password" id="password" required><br>
		<input type="submit" value="Login">
	</form>
</div>
</body>
</html>
