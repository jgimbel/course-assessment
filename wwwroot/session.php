<?php
$dbc = mysqli_connect('localhost','root','dontfearthereaper','assessment')
or die('Error connecting to MySQL server.');
session_start();
//connect to the database here
$user = $_POST['username'];
$valid  = 1;
$name = '';
$query = "SELECT *
        FROM users
        WHERE user_name = '{$user}';";
$result = mysqli_query($dbc, $query);
echo $query;
if(mysqli_num_rows($result) != 1) //no such user exists
{
	mysqli_close($dbc);
    header('Location: failed.html');
        die();
} else {
	$userData = mysqli_fetch_array($result);
	//session_regenerate_id (); //this is a security measure
    $_SESSION['valid'] = 1;
    $_SESSION['userid'] = $userData['id'];
    $_SESSION['username'] = $userData['user_name'];
	$_SESSION['name'] = $userData['name'];
	echo $_SESSION['username'];
	echo $_SESSION['name'];
	header('Location: login.php');
}
?>