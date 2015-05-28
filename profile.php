<?php
session_start();
echo $_SESSION['id']." ".$_SESSION['username']." "." ";
if(isset($_SESSION['id']))
{
if(isset($_GET['logout']))
	{session_destroy(); header("Location: newlogin.php");}
}
else header("Location: newlogin.php");
?>
<a  href="?logout">Logout</a>
<a style="float :right;" href="newlogin.php">Login</a>
<a href="inpost.php">editor</a>
