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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../Libraries/stylesheet.css">
</head>
<body>
<div class="container">
    <!-- TODO toolbar -->
    <div class="container">
        <div>
            <h2>Athletes</h2>
            <ul class="list-group">
				<?php
				foreach($athletes_list as $athlete) {
					echo "<li class='list-group-item'>{$athlete['surname']} {$athlete['name']}</li>";
				}
				?>
            </ul>
        </div>
    </div>
	<br><a href="course.php?id=<?php echo $_GET['id']; ?>">back</a>
</div>
</body>
</html>
