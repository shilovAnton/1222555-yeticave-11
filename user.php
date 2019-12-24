<?php

session_start();

$user = 0;
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

