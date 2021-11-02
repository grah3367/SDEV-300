<?php
require_once('includes/user.php');
require_once('includes/helpers.php');

// for testing purposes - so that we dont have to login.
//$_SESSION['authed'] = true;

$user = user::getInstance();
$e = array();
//$securityQs = $user->getAllSecurityQuestions();

// for debugging purposes
// print_r($_POST);

//check if we have a post 
if(!empty($_POST)){
	$e = $user->validateQuestion($_POST['answer']);
	if(empty($e) && $user->isLoggedIn()){ //if the error array is empty we passed the checks
		$user->redirectLoggedIn();
	}
}


 
 
?>
<!doctype html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Security Check</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
	
  <div class="reg-page">
	<h2>Security Check</h2>
	<?php if(!empty($e)) { ?>
	<div class="alert alert-danger" role="alert">
	<ul>
		<?php foreach((array)$e as $error) { ?>			
				<li><?php echo $error; ?></li>
		<?php } ?>
	</ul>	
	</div>
	<?php } ?>
	
	  <div class="form">
	  <p>To continue please answer the following question:</p>
	  <h2><?php echo $user->getRandomSecurityQuestion(); ?></h2>
		<form class="security-form" method="post" action="<?php echo h($_SERVER["PHP_SELF"]); ?>">
		  <input name="answer" type="text" placeholder="answer" value="<?php echo h($_POST['answer'] ?? ''); ?>"/>		
		  <button>Submit</button>
		 
		</form>	
		 <p class="message"><a href="logout.php">Sign out</a></p>
	  </div>
</div>

  
  

</body>

</html>