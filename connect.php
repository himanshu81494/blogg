<?php

$db=new SQLite3('database') or die('Unable to open database');
$query1= <<<EOD
	CREATE TABLE IF NOT EXISTS users (
		id INTEGER PRIMARY KEY ,
		username STRING NOT NULL ,
		password STRING NOT NULL,
		lastlogin DATETIME,
		role INTEGER DEFAULT 0,
		unique(username)
		)
EOD;
$query2=<<<EOD
	CREATE TABLE IF NOT EXISTS posts 
(postid INTEGER PRIMARY KEY,
	title TEXT NOT NULL,
 body TEXT NOT NULL,
  published DATETIME,
   
    
     authorid INTEGER,
      UNIQUE (postid))
EOD;

$query3=<<<EOD
	CREATE TABLE IF NOT EXISTS tags
(
tagname TEXT NOT NULL PRIMARY KEY,

  list TEXT,
      unique (tagname))
EOD;
$title='hoo';
$body='halalal';
$date='2007-01-01 10:00:00';
$tags="a, b, cddd, dkdk";
$authorid=14;


//yyyy-MM-dd HH:mm:ss
$query4=<<<EOD
INSERT INTO posts(title,body,published,tags,authorid) VALUES('$title','$body','$date','tags','$authorid');
EOD;

$db->exec($query1) or die('Create db failed query1');
$db->exec($query2) or die('Create db failed query2');
$db->exec($query3) or die('Create db failed query3');
?>
