<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
date_default_timezone_set("Asia/Kolkata");
include_once"connect.php";
if(isset($_SESSION['id']))
{
  $user=$_SESSION['username'];
$result=$db->query("SELECT * FROM users WHERE username='$user'");
while($row = $result->fetchArray())
    {
      $lastlogin=$row['lastlogin'];
      $role=$row['role'];
      
    }
echo "<h2 style='float:right;'>User: $user<br> Lastlogin: $lastlogin <br><a href='profile.php'>#</a></h2>";
if(isset($_POST['title'])&&isset($_POST['body']))
{
  $authorid=$_SESSION['id'];
  $title=$_POST['title'];
  $body=$_POST['body'];
  $body=htmlspecialchars($body);
  $qry=<<<EOD
INSERT INTO posts(postid,title,body) VALUES(NULL,'$title','$body')
EOD;
$db->exec($qry) or die("that title exists already! <a href='inpost.php'>Back</a>");
$timenow=date('Y-M-d H:m:s');
$qry1=<<<EOD
UPDATE posts SET published = '$timenow',authorid='$authorid'  WHERE title='$title'
EOD;
        $db->exec($qry1) or die("time can't be set");

  $_SESSION['tags']=$_POST['tags'];


 /* $result=$db->query('SELECT * FROM posts') or die('query to read failed');
while($row=$result->fetchArray())
{echo"postid: {$row['postid']}  Title: {$row['title']} body: {$row['body']} published: {$row['published']} authorid: {$row['authorid']} <br>";}*/
echo "see all posts<a href='showpost.php'>HERE</a>";
}

 }else header("Location: newlogin.php");
//<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>editor</title>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>

<script type="text/javascript">
  //<![CDATA[
  bkLib.onDomLoaded(function() {
    elementArray = document.getElementsByClassName("nice-edit");
    for (var i = 0; i < elementArray.length; ++i) {
      nicEditors.editors.push(
        new nicEditor().panelInstance(
          elementArray[i]
        )
      );
    }
  });
  //]]>
</script>
<style>
td:nth-child(2){
  width: 100%;
}
textarea{
  height:200px;
}
</style>
</head>
<body>
     <div align="center">
       <h3><br />
         <br />
       Sabse bekkar editor<br />  
       <br />
       </h3>
     </div>
     <table align="center" cellpadding="5">
      <form action="" method="post" enctype="multipart/form-data" name="logform" id="logform" >
        <tr>
          <td class="style7"><div align="right">title</div></td>
          <td><input name="title" type="text" id="title" size="30" maxlength="64" required /></td>
        </tr>  
        <tr>
          <td class="style7"><div align="right">body:</div></td>
          <td><textarea style="width:80%;" name="body" type="textarea" id="body" class="nice-edit" size="50" maxlength="100" >body</textarea></td>
        </tr>
        <tr>
        <tr>
          <td class="style7"><div align="right">tags:</div></td>
          <td><input style="width:80%;" name="tags" placeholder="Enter Tags seperated by comma" type="textarea" id="tags" size="30" maxlength="100" ></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="Submit" type="submit" value="post" /></td>
        </tr>
      </form>
    </table>
</body>
</html>