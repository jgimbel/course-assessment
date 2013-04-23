<?php
session_start();
    if ($_SESSION['valid']!=1) {
        header('Location: index.html');
        die();
    }
	echo file_get_contents('header.html');

$dbc = mysqli_connect('localhost','root','dontfearthereaper','assessment')
or die('Error connecting to MySQL server.');
$query = 'SELECT * FROM '.$_GET['map'].'_map';
$result = mysqli_query($dbc, $query);
$amount = mysqli_num_fields($result);
if (!$result) {
    echo "Select a Division from above.";
    exit;
}
if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        print_r($row);
    }
}
echo "<table border=\"1\" id=\"map\">
<tr>
	<th>Course</th>";
	$i = 1;
	while($i < $amount - 1){
		echo '<th>Goal ' . $i . '</th>';
		$i++;
	}
echo '</tr>';


while($row = mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['Course'] . "</td>";
		$i = 1;
		while($i < $amount - 1){
			echo "<td align='center'>" . $row["Goal_{$i}"] . "</td>";
			$i++;
		}
		echo "</tr>";
}

mysqli_close($dbc);
?>
</body></html>
