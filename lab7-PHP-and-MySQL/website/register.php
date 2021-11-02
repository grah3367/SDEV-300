<?php
require_once('includes/user.php');
require_once('includes/helpers.php');
$user = user::getInstance();
$e = array();
$securityQs = $user->getAllSecurityQuestions();

// for debugging purposes
// print_r($_POST);

//check if we have a post 
if(!empty($_POST)){
	$e = $user->validateRegistration($_POST);
	if(empty($e)){ //if the error array is empty we passed the checks
		$user->registerUser($_POST);
	}
} 
 
?>
<!doctype html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Register</title>
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
	<h2>Register an account</h2>
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
		<form class="register-form" method="post" action="<?php echo h($_SERVER["PHP_SELF"]); ?>">
		  <input name="username" type="text" placeholder="username" value="<?php echo h($_POST['username'] ?? ''); ?>"/>
		  <input name="password" type="password" placeholder="password" value=""/>
		  
		 <?php 
			$count=1;
			for($i=1;$i<=3;$i++) {?>
			<div class="select-style">
		   <select class="security" name="security<?php echo $i; ?>">
			
			  <option value="0">Select a question from the following options.</option>
			<?php foreach($securityQs as $q) {?>
			  <option value="<?php echo $count;?>"<?php if( isset($_POST['security'.$i]) && $_POST['security'.$i] == $count){ ?> selected="selected"<?php }?>> <?php echo $q[0]; ?></option>
			  <?php $count++; if($count == 11) {$count=1;} } ?>
			</select>
		</div>
		<input name="answer<?php echo $i; ?>" type="text" placeholder="question <?php echo $i; ?> answer" value="<?php echo h($_POST['answer'.$i] ?? ''); ?>"/>
		
		 <?php } ?>
		
		
		  <button>create</button>
		  <p class="message">Already registered? <a href="login.php">Sign In</a></p>
		</form>	
	  </div>
</div>

  
  

</body>

</html>