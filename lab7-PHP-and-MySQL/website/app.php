<?php
require_once('includes/user.php');
require_once('includes/helpers.php');
require_once('includes/game.php');

// for testing purposes - so that we dont have to login.
//$_SESSION['authed'] = true;

$user = user::getInstance();
$game = game::getInstance();
$e = array();

// for debugging purposes
 //print_r($_SESSION);

//check if we have a post 
if(isset($_POST['game-submit'])){
	$e = $game->checkGameAns($_POST['answer']);
	if(empty($e)){ //if the error array is empty we passed the checks
		//$user->redirectLoggedIn();
	}
}

if(isset($_POST['quit'])){
	$game->quitCurrentGame();
}


 
 
?>
<!doctype html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Game</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
</div>
  <div class="reg-page">
    <h2>The Addition Game</h2>
	
	<div class="alert alert-info"><h4>Current Best player: <?php echo $game->getBestPlayerName() . " with " . $game->getBestPlayerScore() . " points!";?></h4> </div>
	
	<?php if(!empty($e)) { ?>
	<div class="alert alert-warning" role="alert">
	<ul>
		<?php foreach((array)$e as $error) { ?>			
				<li><?php echo $error; ?></li>
		<?php } ?>
	</ul>	
	</div>
	<?php } ?>
	<p>Hello <?php echo $user->getUsername() .  " :-) | "; ?><a href="update-user.php">Edit Account</a> </p> <em><?php echo "Your current Score: " . $game->getCurrentScore() . " points"; ?></em><strong> Your Highest Score: <?php echo $game->getHighScore() . " points."; ?></strong>
	  <div class="form">
	  <p>To play answer the following (You get 1 try):</p>
	  <h2><?php echo $game->getRandomGameQuestion(); ?></h2>
		<form class="security-form" method="post" action="<?php echo h($_SERVER["PHP_SELF"]); ?>">
		  <input name="answer" type="text" placeholder="answer" value=""/>		
		  <input type="submit" name="game-submit" value="Submit answer">
		 
		</form>	
		<form method="post">

		
		<input type="submit" name="quit" value="Quit current game.">
		</form>
		 <p class="message"><a href="logout.php">Sign out.</a> (all progress will be lost)</p>
	  </div>
</div>

  
  

</body>

</html>