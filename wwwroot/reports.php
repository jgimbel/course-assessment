<?php
session_start();
   // if ($_SESSION['valid']!=1) {
   //     header('Location: index.html');
   //     die();
   // }
echo file_get_contents('header.html');
echo "<form name=input action=reports.php method=GET>";
$_GET['title'] = str_replace("\"", "" ,$_GET['title']);
echo "<div>";
echo "<label>Prefix:</label>      <input type=text name=prefix value='{$_GET['prefix']}'>";
echo "<br/>";
echo "<label>Course Code:</label> <input type=text name=number value='{$_GET['number']}'>";
echo "<br/>";
echo "<label>Title:</label>       <input type=text name=title value='{$_GET['title']}'>";
echo "<br/>";
echo "<br/>";
echo "<input type='submit' value='Search'/>";
echo "<br/>";
echo "<br/>";
echo "</div>";
echo "</form>";

$dbc = mysqli_connect('localhost','root','dontfearthereaper','assessment')
or die('Error connecting to MySQL server.');
$query = "SELECT * FROM ca_log  WHERE Instructor LIKE '%{$_SESSION['name']}%' AND (CA_Step = 'Report 1' OR CA_Step = 'Report 2')";
//specifying order
$query = $query . " ORDER BY action_number DESC, prefix ASC, number ASC, step_number DESC";

$dbc = mysqli_connect('localhost','root','dontfearthereaper','assessment');

$result = mysqli_query($dbc, $query);
//echo $query;
echo "	<table border=1>
		<tbody>
		<tr>
			<th>Course</th>
			<th>Status</th>
			<th>Do Something </th>
		</tr>
		
";

while($row = mysqli_fetch_array($result)){
	echo "<tr>
	<td>{$row['Title']}</td>
	<td>{$row['Action']}</td>";
	if($row['Action'] == ('Out for Revision' || 'Identified')){
		echo "<td><a style=\"color:white;text-decoration: none;\" href=\"#\">Check Report</a></td>";
	}else{
		echo "<td><a style=\"color:white;text-decoration: none;\" href=\"#\">Create Report</a></td>";
	}
	echo "</tr>";
}
?>

</tbody>
</table>

