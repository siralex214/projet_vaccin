<?php


/* session_start();
if (!isset($_SESSION['id']))
{
    header("Location: index.php");
    die();
}  
 */

$id = $_GET['id']; // get id through query string

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vaccination";

if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
  header("Location : ../index.php");
}



if(isset($_GET['id'])) {
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
;

$sql = "DELETE FROM users WHERE id = $id";
 

if ($conn->query($sql) === TRUE) {
    header('Location: dashboard.php');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>