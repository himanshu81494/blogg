<?php
//echo sqlite_libversion();

session_start();

print_r(SQLite3::version());
echo "<br>";
echo phpversion();
date_default_timezone_set("Asia/Kolkata");
echo date_default_timezone_get();
include_once"connect.php";

error_reporting(E_ERROR | E_PARSE);
if(isset($_SESSION['username']))header("Location: profile.php");




if(isset($_POST['username'])&&isset($_POST['password']))
{

/*$username = stripslashes($_POST['username']);
$username = strip_tags($username);
$username = mysql_real_escape_string($username);
$username = ereg_replace("[^A-Za-z0-9]", "", $_POST['password']); // filter everything but numbers and letters
$password = md5($password);*/
$user=mysql_real_escape_string($_POST['username']);
$pass=mysql_real_escape_string($_POST['password']);
$qry=<<<EOD
INSERT INTO users(id,username,password) VALUES(NULL,'$user','$pass')
EOD;
//$db->exec($qry) or die('unable to add user');
//$rows = sqlite_num_rows($result);
//$cols = sqlite_num_fields($result);
$logincheck=0;
$result=$db->query("SELECT count(*) as count FROM users WHERE username='$user' AND password='$pass'") or die('query to read failed');
while($row=$result->fetchArray())
{//echo"User: {$row['username']}\nPassword: {$row['password']}\n";
//echo '<br>'.$row['count'].'<br>';
if($row['count']>0)$logincheck=1;
}
echo '<br>'.$logincheck.'<br>';
$result=$db->query("SELECT * FROM users WHERE username='$user' AND password='$pass'");
if($logincheck > 0){ 
    while($row = $result->fetchArray())
    { 
        // Get member ID into a session variable
        $id = $row["id"];   
        //session_register('id'); 
        $_SESSION['id'] = $id;
        // Get member username into a session variable
      $username = $row["username"];   
        //session_register('username'); 
        $_SESSION['username'] = $username;
        // Update last_log_date field for this member now
        $timenow=date('Y-M-d H:m:s');
        $qry1=<<<EOD
UPDATE users SET lastlogin = '$timenow' WHERE username='$user'
EOD;
        $db->exec($qry1) or die("time can't be set");
         
        // Print success message here if all went well then exit the script
        echo "success <br>".$logincheck;
    //header("location: member_profile.php?id=$id"); 
        header("location: profile.php"); 
    exit();
    } // close while
}
else
{echo '<br /><br /><font color="#FF0000">No match in our records, try again </font><br />
<br /><a href="newlogin.php">Click here</a> to go back to the login page.';
  exit();}

}



?>



<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login to your profile</title>

</head>
<body>
     <div align="center">
       <h3><br />
         <br />
       Log in to your account here<br />  
       <br />
       </h3>
     </div>
     <table align="center" cellpadding="5">
      <form action="" method="post" enctype="multipart/form-data" name="logform" id="logform" >
        <tr>
          <td class="style7"><div align="right">username</div></td>
          <td><input name="username" type="text" id="username" size="30" maxlength="64" /></td>
        </tr>  
        <tr>
          <td class="style7"><div align="right">Password:</div></td>
          <td><input name="password" type="password" id="password" size="30" maxlength="24" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="Submit" type="submit" value="Login" /></td>
        </tr>
      </form>
    </table>
</body>
</html>