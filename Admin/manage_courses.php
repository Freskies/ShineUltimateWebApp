<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

session_start();
require_once '../Libraries/Connection.php';

// get the list of the active courses
$conn = new Connection('shine');
$courses_list = $conn->execute('SELECT * FROM course;');

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
    <!-- create button that open a modal in witch there's a form -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_course_modal">
        Create course
    </button>
    <!-- modal that contains the form -->
    <div class="modal fade" id="create_course_modal" tabindex="-1" aria-labelledby="create_course_modal_label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_course_modal_label">Create course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="create_course.php" method="post">
                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="course_year" class="form-label">Course year</label>
                            <input type="number" class="form-control" id="course_year" name="course_year" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- home button -->
    <a href="../entry.php" class="btn btn-secondary">Home</a>

    <!-- import bootstrap 5.1 js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
</body>
</html>

