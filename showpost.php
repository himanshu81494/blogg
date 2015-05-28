<?php
include_once"connect.php";
$query=
"SELECT * FROM posts";

$result=$db->query($query) or die('Create db failed query1');

while($row=$result->fetchArray())
{$body=htmlspecialchars_decode($row['body']);

	echo"title: {$row['title']}<br>body: {$body}<br>authorid: {$row['authorid']}<br> <br>";}

$qry=<<<EOD
DROP TABLE posts
EOD;
//$db->exec($qry); 
?>
<html>
<head>
<title></title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<h2>Test Page</h2>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<table class="form">
<form action="" enctype="multipart/form-data" method="POST">
<tr> 
    <td><textarea rows="10" cols="100" name="3" id="area1" name="content">A long time ago in a galaxy far, far away...</textarea></td>
</tr>
<tr>
    <td align="center" style="padding-bottom: 10px;">
    <input type="submit" onclick="nicEditors.findEditor('area1').saveContent(); name="update" value="Save Changes">
    </td>
</tr>
</form>
</table>
<?
print_r($_REQUEST); 
?>
</body>
</html>