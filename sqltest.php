<?php
//echo sqlite_libversion();
print_r(SQLite3::version());
echo "<br>";
echo phpversion();

/*
$dbhandle=sqlite3::open('test.db',0666,$error);
if(!$dbhandle) die ($error);
$stm="CREATE TABLE posts(Id integer PRIMARY KEY,".
"Name text UNIQUE NOT NULL";
$OK=sqlite_exec($dbhandle,$stm,$error);
if(!$OK) die("cannot execute query. $error");
echo "Datbase [posts] created successfully";
sqlite_close($dbhandle);
*/

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
$user="himanshu";$pass="5656";
$query=<<<EOD
INSERT INTO users VALUES('$user','$pass')
EOD;
$db->exec($query) or die("Unable to add user $user");
$result=$db->query('SELECT * FROM users') or die('Query failed');
while($row=$result->fetchArray())
{echo"User: {$row['username']}\nPassword: {$row['password']}\n";}