<?php
session_start();
if(isset($_SESSION['username'])) {
		$isLoggedIn=True;
	} else  { header("Location: login.html"); }
$file=$_POST['configdata'];
print ("About to show this configuration file:" . htmlspecialchars(basename($file)));
echo "<p></p>";

//$results = system("type $file");
$results = file_get_contents("./configs/". basename($file));
if(empty($results)){
	print "config file not found";
} else {
	print "data is :" . htmlspecialchars($results);
}
?>