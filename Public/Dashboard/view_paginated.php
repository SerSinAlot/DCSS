<!DOCTYPE HTML PUBLIC>
<html>
<head>
<title>Tiketit</title>
<meta http-equiv="Content type" content="text/html; charset=utf-8"/>
</head>
<body>

<h1>Tiketit</h1>

<?php
// dispaly errors
error_reporting(E_ALL);
ini_set('display', 1);

// connect to db
include('connect.php');

// number of tickets shown per page
$per_page = 5;

// figure the total amount of pages
if ($result = $mysqli->query("SELECT * FROM Tiketit ORDER BY Pvm"))
{
	if ($result->num_rows != 0)
{
	$total_results = $result->num_rows;

	// ceil() returns the next highest integer by rounding up if necessary
	$total_pages = ceil($total_results / $per_page);

// check if the 'page' variable is set in the URL
if (isset($_GET['page']) && is_numeric($_GET['page']))
{
	$show_page = $_GET['page'];

// make sure the $show_page is valid
if ($show_page > 0 && $show_page <= $total_pages)
{
	$start = ($show_page -1) * $per_page;
	$end = $start + $per_page;
}
else
{
	//error - show first set of results
	$start = 0;
	$end = $per_page;
}
}
else
{
	// if page isn't set, show first set of results
	$start = 0;
	$end = $per_page;
}

// display pagination
echo "<p><a href='view.php'>Kaikki</a> | <b>Sivu:</b> ";
for ($i = 1; $i <= $total_pages; $i++)
{
	if (isset($_GET['page']) && $_GET['page'] == $i)
{
	echo $i . " ";
}
else
{
	echo "<a href='view.php?page?page=$i'>$i</a> ";
}
}
echo "</p>";

// display data in table
echo "<table border='1' cellpadding_'10'>";

// loop through results of query, display in table
for ($i = $start; $i < $end; $i++)
{
	// make sure that non-existant results are shown
	if ($i == $total_results) 
{
	break;
}

//find specific row
$result->data_seek($i);
$row = $result->fetch_row();

// echo out contents of each row
echo "<tr>";
echo '<td>' . $row[0] . '</td>';
echo '<td>' . $row[1] . '</td>';
echo '<td>' . $row[2] . '</td>';
echo '<td><a href="records.php?id=' . $row[0] . '">Edit</a></td>';
echo "</tr>";
}

// close table
echo "</table>";
}
else
{
	echo "Ei avoimia tikettejä!";
}
}

// error with query
else
{
	echo "Error: " . $mysqli->error;
}

// close connection
$mysqli->close();

?>

<a href="records.php">Add New Record</a>
</body>
</html>
</html>
