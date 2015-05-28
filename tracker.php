<?php
$sessionsdir = "sessions/";
$output_file = "../display/Output.txt";
if (empty($_SERVER["HTTP_IF_NONE_MATCH"])) {
	$random_id_length = 10; 
	$rnd_id = crypt(uniqid(rand(),1)); 
	$rnd_id = strip_tags(stripslashes($rnd_id)); 
	$rnd_id = str_replace(".","",$rnd_id); 
	$rnd_id = strrev(str_replace("/","",$rnd_id)); 
	$rnd_id = substr($rnd_id,0,$random_id_length); 
	$etagHeader = $rnd_id;
}
else { // 
	$etagHeader=trim($_SERVER['HTTP_IF_NONE_MATCH']);
}
class item
{
    public $time;
    public $site;
}
if(file_exists($sessionsdir . $etagHeader)) {
	$session = unserialize(file_get_contents($sessionsdir . $etagHeader));
}
if (isset($_GET["picture"])) {
	if (empty($_SERVER["HTTP_IF_NONE_MATCH"])) {
		@unlink($sessionsdir . $etagHeader); 
		unset($session);
		if(file_exists($sessionsdir . $etagHeader)) {
			$session = unserialize(file_get_contents($sessionsdir . $etagHeader));
		}
	}
	if($_SERVER['HTTP_REFERER'] == "http://54.148.46.18/display/"){
		$fid = fopen($output_file, "w");
		fwrite($fid, json_encode($session));
		fclose($fid);
	}
	else{
		$object = new item();
		$object->time = time();
		$object->site = $_SERVER['HTTP_REFERER'];
		$session[] = $object;
		$fid = fopen($sessionsdir . $etagHeader, "w");
		fwrite($fid, serialize($session));
		fclose($fid);
	}
	header("HTTP/1.1 200 OK");
	header("Cache-Control: private, must-revalidate, proxy-revalidate, no-transform");
	header("ETag: " . $etagHeader); // our "cookie"
	header("Content-type: image/jpg");
	header("Content-length: " . filesize("picture.jpg"));
	readfile("picture.jpg");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tracker 1</title>
<style>
h2 {
color: #3d3d3d;
font-variant: small-caps;
}
h5 {
color: #3d3d3d;
font-variant: small-caps;
}
body {
	font-family: "Helvetica";
}
#img_style {
    position: absolute;
    top: 0;
    left: 30%;
    width: 30%;
    text-align: center;
    padding: 10px;
}
</style>
</head>
<body>
<div id='img_style'>
<img src="picture.jpg" />
<h2>You're on tracker website 1</h2>
</div>
</body>
</html>