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
require_once 'Libraries/Course.php';

// get the current year, if the current year is 2021, the string will be "2021-2022"
$year = Year::getCurrentYear();

// get the list of the courses
$conn = new Connection('shine');
$query = 'SELECT * FROM course ORDER BY year DESC, name;';
$courses_table = $conn->execute($query);

// transform the table into an array of Course objects
$courses = array();
foreach ($courses_table as $course)
	$courses[] = new Course($course['id'], $course['name'], new Year($course['year']));

// get the list of active courses
$active_courses = Course::getActiveCourses($courses);

// get the list of inactive courses
$inactive_courses = Course::getInactiveCourses($courses);

// get the list of years in which there are courses
$years = array();
foreach ($inactive_courses as $course)
	$years[] = $course->getYear();
$years = array_unique($years);

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shine</title>
    <!-- import bootstrap 5.1 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Libraries/stylesheet.css">
</head>
<body>
<div class="container">
    <h1>Welcome <?php echo $_SESSION['user']; ?></h1>
    <!-- section with the buttons of the courses -->
    <div id="courses_list">
        <div class="dropdown">
            <!-- ACTIVE COURSES (button for every course) -->
            <?php foreach ($active_courses as $course): ?>
                <a class="btn btn-primary" href="User/course.php?id=<?php echo $course->getId() ?>">
                    <?php echo $course->getName() ?>
                </a>
            <?php endforeach; ?>
            <!-- INACTIVE COURSES (dropdown menu) -->
            <button class="btn btn-info dropdown-toggle" type="button" id="inactive_courses_dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Inactive courses
            </button>
            <div class="dropdown-menu" aria-labelledby="inactive_courses_dropdown">
				<?php foreach ($years as $year): ?>
                    <div class="dropdown dropend">
                        <a class="dropdown-item dropdown-toggle" href="#"
                           id="<?php echo 'dropdown_submenu_toggle' . $year ?>"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $year ?></a>
                        <div class="dropdown-menu" aria-labelledby="<?php echo 'dropdown_submenu_toggle' . $year ?>">
							<?php foreach (Course::getCoursesFromYear($year, $inactive_courses) as $course): ?>
                                <a class="dropdown-item"
                                   href="User/course.php?id=<?php echo $course->getId() ?>">
									<?php echo $course->getName() ?></a>
							<?php endforeach; ?>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>

        <!-- manage courses button and manage athletes -->
        <div id="anal">
            <h2>Admin</h2>
            <a href="Admin/manage_courses.php" class="btn btn-primary">Manage courses</a>
            <a href="Admin/manage_athletes.php" class="btn btn-primary">Manage athletes</a>
        </div>
        <br><a href="logout.php">logout</a>
    </div>

    <!-- import bootstrap 5.1 js -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="Libraries/bootstrap_nested_dropdown.js"></script>
</body>
</html>