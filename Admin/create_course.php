<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

if (!isset($_SESSION['user']))
	header('Location: index.php');

require_once 'Libraries/Connection.php';
