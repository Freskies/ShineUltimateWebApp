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
$conn = new Connection('shine');

// get the list of athlete in this course
$query = "SELECT `id`, `surname`, `name`, `medical_certificate`, `auto_certificate`
FROM athlete WHERE course_id = {$_GET['id']} ORDER BY `surname`, `name`";
$athletes_list = $conn->execute($query);

// get the default_start_time of this course
$query = "SELECT `default_start_time` FROM course WHERE id = {$_GET['id']};";
$default_start_time = $conn->execute($query)[0]['default_start_time'];

// get the default_duration of this course
$query = "SELECT `default_duration` FROM course WHERE id = {$_GET['id']};";
$default_duration = $conn->execute($query)[0]['default_duration'];
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Shine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../Libraries/stylesheet.css">
    <script src="course.js"></script>
</head>
<body id="body">
<div class="container">
    <a class="btn btn-primary" onclick="create_lesson('create_lesson_container')">Create new lesson</a>
    <a class="btn btn-primary" href="students.php?id=<?php echo $_GET['id']; ?>">Students</a>
    <a class="btn btn-secondary" href="../entry.php">Home</a>
</div>

<div class="form-popup" id="create_lesson_container">
    <form action="course.php" class="form-container">
        <h1>Create new lesson</h1>
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
        <label for="time">Time</label>
        <input type="time" id="time" name="time" value="<?php echo date($default_start_time); ?>">
        <label for="duration">Duration</label>
        <input type="number" id="duration" name="duration" step="0.01" value="<?php echo date($default_duration); ?>">
        <label for="location"></label><input type="text" id="location" name="location" placeholder="Location">
		<?php // create a checkbox for each athlete in this course
		foreach ($athletes_list as $athlete) {
			// if I click the name of the athlete, check the checkbox
			echo "
            <div class='form-check form-check-inline'>
                <input class='form-check-input' type='checkbox' name='athletes[]'
                    id='athlete_{$athlete['id']}' value='{$athlete['id']}'>
                <label class='form-check-label' for='athlete_{$athlete['id']}'>
                    {$athlete['surname']} {$athlete['name']}</label>
            </div>";
		} ?>
        <!-- create 2 button: create lesson on the left and close (red button) pon the right -->
        <button type="submit" class="btn-primary" onclick="create_lesson('create_lesson_container')">Create</button>
        <button type="button" class="btn-danger" onclick="closeForm('create_lesson_container')">Close</button>
    </form>
</div>
</body>
</html>
