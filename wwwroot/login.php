<?php
session_start();
    if ($_SESSION['valid']!=1) {
        header('Location: index.html');
        die();
    }

echo file_get_contents('header.html');
$dbc = mysqli_connect('localhost','root','dontfearthereaper','assessment')
or die('Error connecting to MySQL server.');
if(!$dbc){
	echo "error connecting";
}
$query = "SELECT * FROM ca_log WHERE Instructor LIKE '%{$_SESSION['name']}%' ORDER BY Title, Step_number, Action_number ASC";

$result = mysqli_query($dbc, $query);

$courses = array(
			array(
				array(3)));
$y = 0;
$x = 0;
$current = "";
$first = false;
while($row = mysqli_fetch_array($result)){
	if($current != $row['Title']){
		$current = $row['Title'];
		if(!$first){
			$first = true;
		}else{
			$y++;
			$x = 0;
		}
	}
		$courses[$y][$x][0] = $row['Title'];
		//	echo $row['Title'];
		$courses[$y][$x][1] = substr($row['Date'], 0, 10);
		//	echo $row['Date'];
		$courses[$y][$x][2] = $row['CA_Step'];
		//	echo $row['CA_Step'];
		$x++;
}

if($courses[0][0][0] != 3){
	echo "<div>";
	echo "<table border='1'>
	<tr>
		<th>Course</th>
		<th>Syllabi</th>
		<th>Rubric</th>
		<th>Report 1</th>
		<th>Report 2</th>
		<th>Outcomes</th>
	</tr>";

	$temp = array();
	$x = 0;
	for($x = 0;$x < sizeof($courses);$x++){
		$y = 0;
		echo "<tr>";
		echo "<td>". $courses[$x][$y][0] . "</td>";
		echo "<td>";
		$y = 0;
		for($y = 0; $y < sizeof($courses[$x]); $y++){
			if($courses[$x][$y][2] == 'Syllabus'){
				$courses[$x][$y][0] =  str_replace(" ", "%20", $courses[$x][$y][0]);
				echo"<a style=\" color: white;text-decoration: none\" href=log.php?title='{$courses[$x][$y][0]}'&step=Syllabus> {$courses[$x][$y][1]}</a>";
				$y++;
				break;
			}
			
		}
		echo "</td>";
		echo "<td>";
		$y = 0;
		for($y = 0; $y < sizeof($courses[$x]); $y++){
			if($courses[$x][$y][2] == 'Rubric'){
				$courses[$x][$y][0] =  str_replace(" ", "%20", $courses[$x][$y][0]);
				echo"<a style=\" color: white;text-decoration: none\" href=log.php?title=\"{$courses[$x][$y][0]}\"&step=Rubric> {$courses[$x][$y][1]}</a>";
				$y++;
				break;
			}
		}
		echo "</td>";	
		echo "<td>";
		$y = 0;
		for($y = 0; $y < sizeof($courses[$x]); $y++){
			if($courses[$x][$y][2] == 'Report 1'){
				$courses[$x][$y][0] =  str_replace(" ", "%20", $courses[$x][$y][0]);
				echo"<a style=\" color: white;text-decoration: none\" href=log.php?title=\"{$courses[$x][$y][0]}\"&step=Report+1> {$courses[$x][$y][1]}</a>";
				$y++;
				break;
			}
		}
		echo "</td>";	
		echo "<td>";
		$y = 0;
		for($y = 0; $y < sizeof($courses[$x]); $y++){
			if($courses[$x][$y][2] == 'Report 2'){
				$courses[$x][$y][0] =  str_replace(" ", "%20", $courses[$x][$y][0]);
				echo"<a style=\" color: white;text-decoration: none\" href=log.php?title='{$courses[$x][$y][0]}'&step='Report+2'> {$courses[$x][$y][1]}</a>";
				$y++;
				break;
			}
		}
		echo "</td>";	
		echo "<td>";
		$y = 0;
		for($y = 0; $y < sizeof($courses[$x]); $y++){
			if($courses[$x][$y][2] == 'Outcomes'){
				$courses[$x][$y][0] =  str_replace(" ", "%20", $courses[$x][$y][0]);
				echo"<a style=\" color: white;text-decoration: none\" href=log.php?title={$courses[$x][$y][0]}&step=Outcomes> {$courses[$x][$y][1]}</a>";
				$y++;
				break;
			}
		}
		echo "</td>";
		echo "</tr>";
	//	}
	}
	echo "</table>";
	echo "</div>";	
}else {
	echo "<h2>There are no courses you are attached to.</h2>";
}

?>
<br/>
<br/>
<br/>
<br/>
<br/><div style="float:left;">
For questions or comments, contact Greg Steiner 
<a style=" color: #000000;text-decoration: none" href=mailto:grsteine@ucollge.edu>here</a>
<div>
</body>
</html>