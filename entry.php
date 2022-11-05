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

// get the current year, if the current year is 2021, the string will be "2021-2022"
$year = date('Y') . '-' . ((int)(date('Y')) + 1);

// get the list of the active courses
$conn = new Connection('shine');
$query = sprintf('SELECT * FROM course WHERE year = %s;', $year);
$active_courses = $conn->execute($query);
$query = sprintf('SELECT * FROM course WHERE year != %s;', $year);
$inactive_courses = $conn->execute($query);
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
    <script>
        function hide() {
            document.getElementById('show-hide-button').innerHTML = 'Show All';
            document.getElementById('show-hide-button').setAttribute('onclick', 'show()');

            <?php foreach ($inactive_courses as $course) { ?>
            document.getElementById('course-<?= $course['id'] ?>').setAttribute('hidden', 'true');
            <?php } ?>
        }

        function show() {
            document.getElementById('show-hide-button').innerHTML = 'Hide Inactive';
            document.getElementById('show-hide-button').setAttribute('onclick', 'hide()');

            <?php foreach ($inactive_courses as $course) { ?>
            document.getElementById('course-<?= $course['id'] ?>').removeAttribute('hidden');
            <?php } ?>
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Welcome <?php echo $_SESSION['user'] ?></h1>
    <div id="courses_list">
        <!--
        creare una lista di pulsanti con i vari corsi
        normalmente si devono visualizzare solo i corsi attivi
        ma cliccando sul pulsante "Show all" si devono visualizzare anche i corsi non attivi
        con javascript si devono creare tutti i bottoni con i corsi
        dentro la variabile $courses_list ci sono tutti i corsi (anche quelli non attivi)
        -->
        <div id="active_courses_div">
	        <?php
	        foreach ($active_courses as $course) { ?>
                <a href="User/course.php?id=<?php echo $course['id'] ?>"
                   id="course-<?php echo $course['id'] ?>"
                   class="btn btn-primary"><?php echo $course['name'] ?></a>
		        <?php
	        }
	        ?>
        </div>
		<div id="inactive_couses_div">
            <?php
            foreach ($inactive_courses as $course) { ?>
                <a href="User/course.php?id=<?php echo $course['id']?>"
                   id="course-<?php echo $course['id'] ?>"
                   class="btn btn-secondary"
                   hidden><?php echo $course['name']  . ' ' . $course['year']?></a>
                <?php
            }
            ?>
        </div>
        <button id="show-hide-button" class="btn btn-primary"></button>
        <script> hide(); </script>


    </div>
    <div>
        <!-- manage courses button and manage athletes -->
        <h2>Admin</h2>
        <a href="Admin/manage_courses.php" class="btn btn-primary">Manage courses</a>
        <a href="Admin/manage_athletes.php" class="btn btn-primary">Manage athletes</a>
    </div>
    <br><a href="logout.php">logout</a>
</div>
</body>
