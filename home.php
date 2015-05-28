<?php
session_start();
$toplinks = "";
if (isset($_SESSION['id'])) {
	
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
	$toplinks = '<a href="member_profile.php?id=' . $userid . '">' . $username . '</a> &bull; 
	<a href="member_account.php">Account</a> &bull; 
	<a href="logout.php">Log Out</a>';
} else {
	$toplinks = '<a href="join_form.php">Register</a> &bull; <a href="login.php">Login</a>';
}
include_once"connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Homepage</title>
</head>

<body>
<table style="background-color: #CCC" width="100%" border="0" cellpadding="12">
  <tr>
    
    <td width="22%"><?php echo $toplinks; ?></td>
  </tr>
</table>
<div>
  here will come posts (eg.pagination of 10 at a time)
</div>
</body>
</html>