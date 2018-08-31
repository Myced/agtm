<?php
include_once '../includes/class.dbc.php';
include_once '../includes/session.php';
include_once '../includes/functions.php';
include_once '../includes/day.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();

$ans = $_POST['responses'];

$name = filter($ans['value'][0]);
$email = filter($ans['value'][1]);
$q1 = filter($ans['value'][2]);
$q2 = filter($ans['value'][3]);
$q3 = filter($ans['value'][4]);

$query = "INSERT INTO `feedback` (`name`, `email`, `q1`, `q2`, `q3`)
                    VALUES ('$name', '$email', '$q1', '$q2', '$q3')
";

$result = mysqli_query($dbc, $query)
    or die("Could not save your responses");

echo 'success';
 ?>
