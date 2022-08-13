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

require_once 'Libraries/Connection.php';

// get the list of the active courses
$conn = new Connection('shine');
$query = sprintf('SELECT * FROM course %s;', isset($_GET['all']) ? '' : 'WHERE is_active = TRUE;');
$courses_list = $conn->execute($query);

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
    <div>
        <h2>Courses</h2>
        <!-- create a button for every course in course_list -->
		<?php foreach ($courses_list

		               as $course) {
			if (!$course['is_active']) { ?>
                <button class="btn btn-secondary" disabled><?php echo $course['name'] ?></button>
			<?php } else { ?>
                <a href="User/course.php?id=<?php echo $course['id'] ?>"
                   class="btn btn-primary"><?php echo $course['name'] ?></a>
			<?php }
		} ?>

        <!-- Show all / Show only active courses button -->
		<?php if (isset($_GET['all'])) { ?>
            <a href="entry.php" class="btn btn-primary">Show only active courses</a>
		<?php } else { ?>
            <a href="entry.php?all" class="btn btn-primary">Show all</a>
		<?php } ?>
    </div>
    <br><a href="logout.php">logout</a>
</div>
</body>
