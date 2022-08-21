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

// if the id of the course is not set, redirect to entry page
if (!isset($_GET['id']))
	echo '<script>alert("Course not found"); window.location.href = "../entry.php";</script>';

require_once '../Libraries/Connection.php';

// get the list of athlete in this course
$conn = new Connection('shine');
$query = "SELECT `id`, `surname`, `name`, phone, email, medical_certificate, auto_certificate
FROM athlete WHERE course_id = {$_GET['id']} ORDER BY `surname`, `name`;";
$athletes_list = $conn->execute($query);
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
	<div>
		<h2>Athletes</h2>
		<?php echo Connection::generate_table($athletes_list); ?>
	</div>
	<br><a href="course.php?id=<?php echo $_GET['id']; ?>">back</a>
</div>
</body>
</html>
