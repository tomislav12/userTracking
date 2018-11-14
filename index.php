<?php

include 'Config.php';
include 'User.php';


$u = new User($conn);
$u->getAllHeaders();
$u->saveToDatabase();


echo '<br><br><a href="backend.php">View backend</a>';







