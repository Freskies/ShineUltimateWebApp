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
require_once 'Libraries/Year.php';

// get the current year, if the current year is 2021, the string will be "2021-2022"
$year = new Year();

// get the list of the courses
$conn = new Connection('shine');
$query = 'SELECT * FROM course ORDER BY year, name;';
$courses = $conn->execute($query);

// extract the list of active courses from the list of courses
$active_courses = array_filter($courses, function ($course) use ($year) {
	return $course['year'] == $year . '';
});

// create a list name $inactive_courses with the inactive courses
// the list is composed like this [year => [course1, course2, ...], year2 => [...]]
$inactive_courses = [];
$inactive_courses_list = array_filter($courses, function ($course) use ($year) {
	return $course['year'] != $year . '';
});
foreach ($inactive_courses_list as $course) {
	$inactive_courses[$course['year']][] = $course;
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
    <script>

    </script>
</head>
<body>
<div class="container">
    <h1>Welcome <?php echo $_SESSION['user'] ?></h1>
    <!-- section with the buttons of the courses -->
    <div id="courses_list">
        <!--
        first there is a button for each active course,
        an active course is a course that is in the current year

        second there is a button for each past year in which there was at least one course,
        an inactive course is a course that is not in the current year
        when the user clicks on the button,
        the list of the inactive courses in that year is shown between the button and the next button
        -->
		<?php foreach ($active_courses as $course) { ?>
            <a href="User/course.php?id=<?php echo $course['id'] ?>"
               id="course-<?php echo $course['id'] ?>"
               class="btn btn-primary"><?php echo $course['name'] ?></a>
			<?php
		} ?>


        <!-- TODO clickable button for each year in which there was at least one course -->
		<?php foreach ($inactive_courses as $year) { ?>
            <a class="btn-secondary"
               onclick=""
               id="<?php echo $year[0]['year']; ?>">
                <?php echo $year[0]['year']; ?></a>
			<?php foreach ($year as $course) { ?>
                <a href="User/course.php?id=<?php echo $course['id'] ?>"
                   id="course-<?php echo $course['id'] ?>"
                   class="btn btn-secondary"
                   hidden><?php echo $course['name'] ?></a>
				<?php
			}
        } ?>
    </div>

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
