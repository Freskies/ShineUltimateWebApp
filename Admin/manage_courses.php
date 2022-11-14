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

</body>
</html>

