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
if (isset($_POST['username']) && isset($_POST['password'])) {
	require_once 'Libraries/Connection.php';
	$conn = new Connection('shine');
	$result = $conn->execute('SELECT password FROM users WHERE username = ?;', [$_POST["username"]]);
	if (password_verify($_POST["password"], $result[0]["password"] ?? "")) {
		$_SESSION['user'] = $_POST["username"];
		header('Location: entry.php');
	} else
		echo '<script>alert("Wrong credentials")</script>';
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Shine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Libraries/stylesheet.css">
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
