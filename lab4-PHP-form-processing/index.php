<?php
	session_start(); // start a session
	
	
	$isLoggedIn=False;
	$comments=False;
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
	// avoids session fixation by tracking if the user is 
	// logged in more than 30 minutes, and if so changing the session ID. 
	if (!isset($_SESSION['CREATED'])) {
		$_SESSION['CREATED'] = time();
	} else if (time() - $_SESSION['CREATED'] > 1800) {
		// session started more than 30 minutes ago
		session_regenerate_id(true);    // change session ID
		$_SESSION['CREATED'] = time();  // update creation time
	}
	
	//check if the user is logged in
	if(isset($_SESSION['appusername'])) {
		$isLoggedIn=True;
	}
	
	// lets check if theres a post to the page
	if(!empty($_POST)){
		
		//we have post data, lets set it
		
		// check if its from the login page
		if(!empty($_POST['login-submit'])){
			// we have a login post, save the login info
			$username = $_POST["username"];
			$email = $_POST["emailaddy"];
			$password = $_POST["password"];
			
			$_SESSION['appusername'] = $username; 
			$_SESSION['appemail'] = $email;
		}
		
		//check if we have new comments submitted
		if(!empty($_POST['comment-submit'])){
			
			// there has been comments submitted. 
			$comments=True;
			
			
			
		}
		
	}
	
	// simulating getting info from a db with an array.
	$projectData = array(
						array("project" =>"DoggyDaycare website","percent" => 52),
						array("project" =>"google.com redesign","percent" => 89),
						array("project" =>"remote jobs website","percent" => 81),
						array("project" =>"coffeshop website","percent" => 24),
						array("project" => "custom wordpress plugin", "percent" => 47),
						array("project" =>"website builder","percent" => 72),
						array("project" =>"website portfolio","percent" => 47),
						array("project" =>"HTML 5 game","percent" => 91),
						array("project" =>"youtube clone","percent" => 98),
						array("project" =>"learn online database","percent" => 80),
						array("project" =>"cat image website","percent" => 5)
					);
	
	
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Project Management App</title>
  <meta name="description" content="lab 4 for SDEV 300">
  <meta name="author" content="Daniel Graham">

  <link rel="stylesheet" href="css/styles.css?v=1.0">
</head>

<body>
	<h1>Website project management App</h1>
	<?php
	if($isLoggedIn){ //we are logged so get and display project data.
	?>
	<h4>Thanks for logging in, <?php echo $_SESSION['appusername']; ?> !  | <a href="./logout.php">Logout!</a></h4> 
	<p>Your current email: <?php echo $_SESSION['appemail']; ?></p>
	
	<table>
	
	<?php if($comments){ echo "<h2>Comment Summary</h2><p>Thank you, your comments have been submitted. Below you can review your comments.</p>";
	 echo "submitted at: ", date('m/d/Y'), " at ", date("h:i:sa");
	
	} ?>
	
	<form name="app" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
		<tr>
			<th>Project</th>
			<th>Percentage complete</th>
			<th><?php if($comments) echo "Comments submitted"; else { echo "Add comments";}?></th>
		<tr>
		<?php
		$i=0;
		foreach($projectData as $project){
			
	
		?>
		<tr> 
			<td><?php echo $project['project']; ?></td> 
		
		 
			<td><?php echo $project['percent'] . "%"; ?></td> 
		
		<td> 
		
			<?php if(!$comments){ ?>
			
				<textarea name="comments<?php echo "[".$i."]"?>" rows="4" cols="50"> </textarea>

			<?php } else { // we want show the comment here. 
			
				echo $_POST['comments'][$i];
			
			?>
		
		</td> 
		</tr>
		<?php }
		$i++;
		} ?>
			
		
		 
		
	</table>
	<?php if(!$comments){ ?><input id="comment-submit" name="comment-submit" type="submit" value="Submit Comments"> <?php } else { echo '<a href="./index.php">Go back </a>';} ?>
	</form>
	
	
	
	
	
	
	<?php
	} 
	else { // we are not logged in so display the login form.
		require('login.php'); 
	} ?>



  
</body>
</html>