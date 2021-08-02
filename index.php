<?php

require 'constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

$redirectLink = "http://localhost/pawel-relinski-ranking/views/athletesview.php";

header('Location: ' . $redirectLink);
