<?php
require_once('includes/user.php');
$user = user::getInstance();
$e = array();
//$user->redirectLoggedIn(); // redirects if user logged in

if(isset($_SESSION['WelcomeMessage'])) {
   $message = $_SESSION['WelcomeMessage'];
   unset($_SESSION['WelcomeMessage']);
}
// for debugging purposes
//print_r($_POST);

//check if we have a post 
if(!empty($_POST)){
	$e = $user->validateLogin($_POST['username'],$_POST['password']);
	if(empty($e) && $user->getAuthed()){ //if the error array is empty we have no errors.
		$user->redirectLoggedIn();
	}
}


?>

<!doctype html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Login</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
	
  <div class="login-page">
	<h2>Login</h2>
	<?php if(!empty($message)) { ?>
	<div class="alert alert-success" role="alert">
	<ul>
		<?php echo $message; ?>
	</ul>	
	</div>
	<?php } ?>
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
		<form class="login-form" method="post" action="<?php echo h($_SERVER["PHP_SELF"]); ?>">
		  <input type="text" placeholder="username" name="username" />
		  <input type="password" placeholder="password" name="password" />
		  
		  <button>login</button>
		  <p class="message">Not registered? <a href="register.php">Create an account</a></p>
		</form>
	  </div>
</div>

  
  

</body>

</html>