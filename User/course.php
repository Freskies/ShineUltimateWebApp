<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

session_start();

// if user is not logged in, redirect to login page
if (!isset($_SESSION['user']))
	header('Location: index.php');

require_once '../Libraries/Connection.php';


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
    <script src="course.js"></script>
    <link rel="stylesheet" href="course.css">
</head>
<body>
<div>
    <a class="btn btn-primary" onclick="create_lesson('create_lesson_container')">Create new lesson</a>
    <a class="btn btn-secondary" href="../entry.php">Home</a>
</div>

<div class="form-popup" id="create_lesson_container">
    <form action="course.php" class="form-container">
        <h1>Login</h1>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="password" required>

        <button type="submit" class="btn">Login</button>
        <button type="button" class="btn cancel" onclick="closeForm('create_lesson_container')">Close</button>
    </form>
</div>
</body>
</html>
