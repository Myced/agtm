<?php
include_once 'includes/class.dbc.php';
include_once 'includes/functions.php';

$db = new dbc();
$dbc = $db->get_instance();

//get the post databa
$courses = $_POST['codes'];

var_dump($courses);

 ?>
