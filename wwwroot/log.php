<?php
session_start();
    if ($_SESSION['valid']!=1) {
        header('Location: index.html');
        die();
    }
echo file_get_contents('header.html');
?>
<form name=input action=log.php method=GET>
<?php
$_GET['title'] = str_replace("\"", "" ,$_GET['title']);
echo "<div>";
echo "<label>Prefix:</label>      <input type=text name=prefix value='{$_GET['prefix']}'>";
echo "<br/>";
echo "<label>Course Code:</label> <input type=text name=number value='{$_GET['number']}'>";
echo "<br/>";
echo "<label>Title:</label>       <input type=text name=title value='{$_GET['title']}'>";
echo "<br/>";
echo "<label>Term:</label>        <input type=text name=term value='{$_GET['term']}'>";
echo "<br/>";
echo "<label>Instructor:</label>  <input type=text name=instructor value='{$_GET['instructor']}'>";
echo "<br/>";
$checked = "";
if(isset($_GET['all'])){
	$checked = "checked";
}
echo "<input style=\"float: left;\" type=\"checkbox\" name=\"all\" value=\"set\" {$checked}><a style=\"float: left;\">All</a>";
echo "<br/>";
echo "<br/>";
echo "<input type='submit' value='Search'/>";
echo "<br/>";
echo "<br/>";
echo "</div>";

?>
</form>

<table border='1'>
<tr>
	<th>Date</th>
	<th>Prefix</th>
	<th>Number</th>
	<th>Title</th>
	<th>Course</th>
	<th>Term</th>
	<th>Instructor</th>
	<th>CA-Step</th>
	<th>Action</th>
	<th>Method</th>
</tr>

<?php

$dbc = mysqli_connect('localhost','root','dontfearthereaper','assessment')
or die('Error connecting to MySQL server.');
$query = "SELECT * FROM ca_log ";
//specify rubric
	$query = $query . "WHERE CA_Step LIKE '%Rubric%'";
//prefix
if(isset($_GET["prefix"]) && !($_GET["prefix"] == "")) {
	$query = $query . " AND prefix LIKE '%{$_GET['prefix']}%'";
}

//number
if(isset($_GET["number"]) && !($_GET["number"] == "")) {
	$query = $query . " AND Number LIKE '%{$_GET['number']}%'";
}

//title
if(isset($_GET["title"]) && !($_GET["title"] == "")) {
	$query = $query . " AND Title LIKE '%{$_GET['title']}%'";
}
//term
if(isset($_GET["term"]) && !($_GET["term"]) == "") {
	$query = $query . " AND Term LIKE '%{$_GET['term']}%'";
}

//instructor
if(isset($_GET["instructor"]) && !($_GET["instructor"] == "")) {
	$query = $query . " AND Instructor LIKE '%{$_GET['instructor']}%'";
} else if (isset($_GET['all'])){
	//do nothing
} else {
	$query = $query . " AND Instructor LIKE '%{$_SESSION['name']}%'";
}

//ordering return values
$query = $query . " ORDER BY action_number DESC, prefix ASC, number ASC, step_number DESC";
	$result = mysqli_query($dbc,$query);
	$array = array('id' => array(), 'date' => array(), 'prefix' => array(), 'number' => array(), 'title' => array(), 'course' => array(),
				 'term' => array(), 'instructor' => array(), 'step' => array(), 'action' => array(), 'method' => array());
$current = "";
$f = true;
$first = true;
$arr = array(array(11));
$y = 0;
//echo $query;
while($row = mysqli_fetch_array($result)){
	for($x = 0; $x < sizeof($arr); $x++){
		if(($row['Title'] == $arr[$x][3] && $row['CA_Step'] == $arr[$x][7]) && ($row['Instructor'] == $arr[$x][6])){
			$f = false;
		}
	}

	if($f){
		$arr[$y][0] = substr($row['Date'], 0, 10);
		$arr[$y][1] = $row['Prefix'];
		$arr[$y][2] = $row['Number'];
		$arr[$y][3] = $row['Title'];
		$arr[$y][4] = $row['Course'];
		$arr[$y][5] = $row['Term'];
		$arr[$y][6] = $row['Instructor'];
		$arr[$y][7] = $row['CA_Step'];
		$arr[$y][8] = $row['Action'];
		$arr[$y][9] = $row['Method'];
		
	
		$y++;
	}
	$f = true;
}
//echo sizeof($arr);
for($x = 0; $x < sizeof($arr);$x++){
	$color = "black";
	switch ($arr[$x][8]) {
		case "Submitted":
			$color = "Purple";
			break;
		case "Out for Revision":
			$color = "Orange";
			break;
		case "Identified":
			$color =  "Red";
			break;
		case "Completed":
			$color =  "Green";
			break;
		case "Reviewed":
			$color = "Blue";
			break;
		case "Confirmed":
			$color = "Blue";
			break;
		case "Resubmitted":
			$color = "Violet";
			break;
	}

		if(!($color == "black")){
			echo "<tr>";
			echo "<td style = 'background-color: {$color};'>". substr($arr[$x][0], 0, 10) . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][1] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][2] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][3] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][4] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][5] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][6] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][7] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][8] . "</td>";
			echo "<td style = 'background-color: {$color};'>". $arr[$x][9] . "</td>";
			echo "</tr>";
		}
}
mysqli_close($dbc);
?>
</body></html>
