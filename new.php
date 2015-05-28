<?php
//echo sqlite_libversion();
print_r(SQLite3::version());
echo "<br>";
echo phpversion();
date_default_timezone_set("Asia/Kolkata");
echo date_default_timezone_get();
/*
$dbhandle=sqlite3::open('test.db',0666,$error);
if(!$dbhandle) die ($error);
$stm="CREATE TABLE posts(Id integer PRIMARY KEY,".
"Name text UNIQUE NOT NULL";
$OK=sqlite_exec($dbhandle,$stm,$error);
if(!$OK) die("cannot execute query. $error");
echo "Datbase [posts] created successfully";
sqlite_close($dbhandle);


$db=new SQLite3('database') or die('Unable to open database');
$query= <<<EOD
	CREATE TABLE IF NOT EXISTS users (
		username STRING PRIMARY KEY,
		password STRING)
EOD;
$db->exec($query) or die('Create db failed');
$user = mysql_real_escape_string($_POST['username']);
//$pass = sanitize($_POST['password']);
$pass = mysql_real_escape_string($_POST['password']);

$query=<<<EOD
INSERT INTO users VALUES('$user','$pass')
EOD;
$db->exec($query) or die("Unable to add user $user");
$result=$db->query('SELECT * FROM users') or die('Query failed');
while($row=$result->fetchArray())
{echo"User: {$row['username']}\nPassword: {$row['password']}\n";}
*/
include_once"connect.php";
if(isset($_POST['username'])&&isset($_POST['password']))
{
$user=mysql_real_escape_string($_POST['username']);
$pass=mysql_real_escape_string($_POST['password']);
$qry=<<<EOD
INSERT INTO users(id,username,password) VALUES(NULL,'$user','$pass')
EOD;
$db->exec($qry) or die('unable to add user');
$logincheck=0;
$result=$db->query("SELECT count(*) as count FROM users WHERE username='$user' AND password='$pass'") or die('query to read failed');
while($row=$result->fetchArray())
{//echo"User: {$row['username']}\nPassword: {$row['password']}\n";
//echo '<br>'.$row['count'].'<br>';
if($row['count']>$logincheck)$logincheck=$row['count'];
}
echo '<br>'.$logincheck.'<br>';
$timenow=date('Y-M-d H:m:s');
if($logincheck>0)
{
  $qry1=<<<EOD
  UPDATE users SET lastlogin = '$timenow' WHERE username='$user'
EOD;
//UPDATE users SET lastlogin = now() WHERE username='$user'
  $db->exec($qry1) or die("nit");}
}

$result=$db->query('SELECT * FROM users') or die('query to read failed');
while($row=$result->fetchArray())
{echo"User: {$row['username']}  Password: {$row['password']} id: {$row['id']} lastlogin: {$row['lastlogin']} role: {$row['role']}<br>";

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
      <form action="" method="post" enctype="multipart/form-data" name="logform" id="logform" onsubmit="return validate_form ( );">
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