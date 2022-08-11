<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

// this file is called when the user clicks on the logout button
session_start();
session_destroy();
header('Location: index.php');