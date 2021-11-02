<?php 
session_start();

require_once('dbConnect.php'); 
require_once('includes/helpers.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class user {
	
	protected static $instance;
	private $userid; 
	private $isLoggedIn;
	private $authed;
	private $completedSecurityCheck;
	private $securityQuestion;
	private $securityQID;
	private $username;
	
	function __construct() {
		
		$this->setAuthed();
		$this->setLoggedIn();
		$this->setSecurityQ();
		$this->setSecurityQID();
		$this->setUserId();
		$this->setUserName();
		
		$this->redirectLoggedIn();
	}
	
	function deleteAccount(){
		
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$stmt = $mysqli->prepare("DELETE FROM users WHERE idusers=? ");
		$stmt->bind_param("s", $this->userid);
		$stmt->execute();
		
		$stmt2 = $mysqli->prepare("DELETE FROM securityAnswer WHERE userid=? ");
		$stmt2->bind_param("", $this->userid);
		$stmt2->execute();
		
		$this->logout();
	}
	
	function setSecurityQ(){
		
		if(isset($_SESSION['securityQ'])){
			$this->securityQuestion = $_SESSION['securityQ'];
		}
	}
	
	function getSecurityQuestion(){
		return $this->securityQuestion;
	}
	
	function setSecurityQID(){
		if(isset($_SESSION['securityQID'])){
			$this->securityQID = $_SESSION['securityQID'];
		}
	}
	
	function getSecurityQID(){
		return $this->securityQID;
	}
	
	function setUserId(){
		if(isset($_SESSION['userid'])){
			$this->userid = $_SESSION['userid'];
		}
	}
	
	function getUserId(){
		return $this->userid;
	}
	
	function setUserName(){
		if(isset($_SESSION['username'])){
			$this->username = $_SESSION['username'];
		}
	}
	
	function getUsername(){
		return $this->username;
	}

	function isLoggedIn(){
		return $this->isLoggedIn;
	}
	
	private function setLoggedIn(){
		if(isset($_SESSION['loggedIn'])){
			$this->isLoggedIn = true;
		} else {
			$this->isLoggedIn = false;
		}
	}
	
	private function setAuthed(){
		if(isset($_SESSION['authed'])){
			$this->authed = true;
		} else {
			$this->authed = false;
		}
	}
	
	public function getAuthed(){
		return $this->authed;
	}
	
	public function redirectLoggedIn(){
		
		$p = basename($_SERVER['PHP_SELF']);
		
		if($this->isLoggedIn && $this->authed && $p != 'app.php' && $p != 'update-user.php'){
			$this->redirectUser("app.php");
		}
		if($this->authed && !$this->isLoggedIn && $p  != 'securityCheck.php'){
			$this->redirectUser("securityCheck.php");
		}
		
		if(!$this->authed && !$this->isLoggedIn && $p  != 'login.php' && $p  != 'register.php') {
			$this->redirectUser("login.php");
		}
		
	}
	
	private function redirectUser($page){
		header("Location: $page");
	}
	
	public static function getInstance(){
		 if (! self::$instance) {
            self::$instance = new self();
        }
		return self::$instance;
	}
	
	function logout(){
		session_destroy(); // destroy the session data
		header("Location: index.php"); // redirect to the homepage.
	}
	
	function validateQuestion($answer){
		
		if(!isset($answer) || $answer == ""){
			return $e[] = "Please enter an answer.";
		}
		
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$stmt = $mysqli->prepare("SELECT answer from securityAnswer WHERE userid=? AND questionId=? LIMIT 1");
		$stmt->bind_param("ss", $this->userid, $this->securityQID);
		$stmt->execute();
		
		$stmt->bind_result($answerHash);
		
		$stmt->store_result();
		$result = $stmt->fetch();
		$numRows = $stmt->num_rows;
		
		
		if($result && !empty($result) && $numRows == 1) {
			// we have a result
			if(password_verify($answer, $answerHash)){
				// the answer to the question is correct
				$_SESSION['loggedIn'] = true;
				$this->setLoggedIn();
				
			} else {
				$e[]="Have you forgot your answer?";
			}
			
		}else{
			$e[] = "There was a problem.";
		}
		
		return $e;
	}
	
	function validateLogin($username, $password){
		$e=[];
		//check the login info against the database
		
		if($username == '' || $password == '' || !$this->userExists($username)){
			return $e[] = "Invalid login.";
		}
		
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		//we know we have a valid username so lets get the password hash and compare.
		$stmt = $mysqli->prepare("SELECT idusers, password FROM users WHERE username=? LIMIT 1");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		
		$stmt->bind_result($userid,$passwordHash);
		
		$stmt->store_result();
		$result = $stmt->fetch();
		$numRows = $stmt->num_rows;
		
		
		if($result && !empty($result) && $numRows == 1) {
			// we have a result
			if(password_verify($password, $passwordHash)){
			// the password is correct, auth the user and set the userid
				$_SESSION['authed'] = true;
				$this->setAuthed();
				$_SESSION['userid'] = $userid;
				$this->setUserId();
				$_SESSION['username'] = $username;
				$this->setUsername();
				
			} else {
				$e[]="Have you forgot your password?";
			}
			
		}else{
			$e[] = "Invalid login. Please try again.";
		}
		
		
		// clean up
		$stmt->free_result();
		$stmt->close();
		return $e;
	}
	
	public function registerUser($data){
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$username = $data['username'];
		$password = $data['password'];
		
		//security questions selected by the user
		$security1 = $data['security1'];
		$security2 = $data['security2'];
		$security3 = $data['security3'];
		
		// get rid of any extra tabs or whitespace in answers. limit spaces to 1.
		// and hash the answer
		$answer1Hash = password_hash( trim( preg_replace('/\s+/S', " ", $data['answer1'])), PASSWORD_DEFAULT);
		$answer2Hash = password_hash( trim( preg_replace('/\s+/S', " ", $data['answer2'])), PASSWORD_DEFAULT);
		$answer3Hash = password_hash( trim( preg_replace('/\s+/S', " ", $data['answer3'])), PASSWORD_DEFAULT);
		
		// generate the hash
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);
		
		//prepare user query
		$stmt = $mysqli->prepare("INSERT INTO users (`username`, `password`) VALUES(?,?)");
		$stmt->bind_param('ss', $username, $passwordHash);
		$stmt->execute();
		$userid = $stmt->insert_id;
		$this->setUserId($userid);
		
		// prepare the users security question they chose, and answers
		$stmt2 = $mysqli->prepare("INSERT INTO securityAnswer (`userid`, `questionId`, `answer`) VALUES(?,?,?)");
		$stmt2->bind_param('iis', $userid, $security1, $answer1Hash);		
		$stmt3 = $mysqli->prepare("INSERT INTO securityAnswer (`userid`, `questionId`, `answer`) VALUES(?,?,?)");
		$stmt3->bind_param('iis', $userid, $security2, $answer2Hash);
		$stmt4 = $mysqli->prepare("INSERT INTO securityAnswer (`userid`, `questionId`, `answer`) VALUES(?,?,?)");
		$stmt4->bind_param('iis', $userid, $security3, $answer3Hash);
		
		// execute the statements
		$stmt2->execute();
		$stmt3->execute();
		$stmt4->execute();
		
		//cleanup
		$stmt->free_result();
		$stmt2->free_result();
		$stmt3->free_result();
		$stmt4->free_result();
		
		$mysqli->close();
		
		$_SESSION['WelcomeMessage'] = "You have successfully registered, please login to continue.";
		$this->redirectUser("login.php");
	}
	
	public function updateUser($data){
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		
		$usernamenew = $data['username'];
		$password = $data['password'];
		
		//security questions selected by the user
		$security1 = $data['security1'];
		$security2 = $data['security2'];
		$security3 = $data['security3'];
		
		$userid=$this->userid;
		
		// nothing was entered so dont update. 
		if($security1 > 0 && $security2 > 0 && $security3 > 0) {
			// get rid of any extra tabs or whitespace in answers. limit spaces to 1.
			// and hash the answer
			$answer1Hash = password_hash( trim( preg_replace('/\s+/S', " ", $data['answer1'])), PASSWORD_DEFAULT);
			$answer2Hash = password_hash( trim( preg_replace('/\s+/S', " ", $data['answer2'])), PASSWORD_DEFAULT);
			$answer3Hash = password_hash( trim( preg_replace('/\s+/S', " ", $data['answer3'])), PASSWORD_DEFAULT);
			
			// prepare the users security question they chose, and answers
		$stmt2 = $mysqli->prepare("UPDATE securityAnswer SET questionId=? , answer=? WHERE userid=?");
		$stmt2->bind_param('isi', $security1, $answer1Hash, $userid);		
		$stmt3 = $mysqli->prepare("UPDATE securityAnswer SET questionId=? , answer=? WHERE userid=?");
		$stmt3->bind_param('isi', $security2, $answer2Hash, $userid);
		$stmt4 = $mysqli->prepare("UPDATE securityAnswer SET questionId=? , answer=? WHERE userid=?");
		$stmt4->bind_param('isi',$security3, $answer3Hash, $userid);
		
		// execute the statements
		$stmt2->execute();
		$stmt3->execute();
		$stmt4->execute();
		
		//cleanup
		$stmt2->free_result();
		$stmt3->free_result();
		$stmt4->free_result();
		}
		
		// change password if its not empty and valid
		if($password !== ""){	
			// generate the hash
			$passwordHash = password_hash($password, PASSWORD_DEFAULT);
			$stmtp = $mysqli->prepare("UPDATE users SET password=? WHERE idusers=?");
			$userid=$this->userid;
			$stmtp->bind_param('ss', $passwordHash, $userid );
			$stmtp->execute();
			$stmtp->free_result();
		}
		
		if($usernamenew != $this->username){
			//prepare user query for changing username
			$stmtu = $mysqli->prepare("UPDATE users SET username=? WHERE idusers=?");
			$userid=$this->userid;
			$stmtu->bind_param('ss', $usernamenew, $userid );
			$stmtu->execute();
			$stmtu->free_result();
		}
		
		
		$mysqli->close();
		
		$_SESSION['updateMessage'] = "Your account was successfully updated.";
		//$this->redirectUser("login.php");
	}
	
	public function userExists($username) {
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		if($username == '')
			return false;
		
		$stmt = $mysqli->prepare("SELECT username from users where username=? LIMIT 1");
		$stmt->bind_param('s',$username);
		
		$stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		$stmt->free_result();
		//$mysqli->close();
		
		return ($numRows == 1) ? true : false;
	}
	
	public function getRandomSecurityQuestion() {
		
		// before we touch the database lets check if a question was already issued
		// only get a random one per login attempt. 
		
		if(isset($this->securityQuestion) && $this->securityQuestion != ''){
			return $this->securityQuestion;
		}
		
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		//we know we have a valid username so lets get the password hash and compare.
		$stmt = $mysqli->prepare("SELECT idsecurityQuestions,question FROM securityQuestions INNER JOIN securityAnswer ON securityQuestions.idsecurityQuestions=securityAnswer.questionId WHERE securityAnswer.userid=? ORDER BY RAND()
LIMIT 1");
		$stmt->bind_param("s", $this->userid);
		$stmt->execute();
		
		$stmt->bind_result($randQId, $randQuestion);
		
		$stmt->store_result();
		$result = $stmt->fetch();
		
		if($result && !empty($result)){
			//we got a random security Question
			$_SESSION['securityQID'] = $randQId;
			$_SESSION['securityQ'] = $randQuestion;
			$this->setSecurityQID();
			$this->setSecurityQ();
			return $this->securityQuestion;
		}
	}
	public function getUserSecurityQuestions() {
		
		// before we touch the database lets check if a question was already issued
		// only get a random one per login attempt. 
		
		
		
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		//we know we have a valid username so lets get the password hash and compare.
		$stmt = $mysqli->prepare("SELECT questionId,answer FROM securityAnswer WHERE userid=? ");
		$stmt->bind_param("s", $this->userid);
		$stmt->execute();
		$stmt->bind_result($q,$a);
		
		$result = $stmt->get_result();
		
		while ($row = $result->fetch_row()){
			$rows[] = $row;
		}
		$stmt->free_result();
		//$mysqli->close();
		
		return $rows;
	}
	
	public function getAllSecurityQuestions() {
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$stmt = $mysqli->prepare("SELECT question from securityQuestions");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()) {
			$rows[]=$row;
		}
		$stmt->free_result();
		//$mysqli->close();
		
		return $rows;
	}
	
	function validateRegistration($data){
		$e=[];
		
		
		if($data['username'] == ""){
			$e[] = 'Username cannot be left blank';
		}
		
		if($data['username'] !== ""){
			if($this->userExists($data['username'])){
				$e[] = 'Username taken, please choose another.';
			}
		}
		if($data['password'] == ""){
			$e[] = 'password cannot be left blank';
		}
		
		// check if password meets requirements
		if(strlen($data['password']) < 8){
			$e[] = 'Password must have at least 8 characters';
		}
		
		if (!(preg_match("#[0-9]+#",$data['password']))) {
			$e[] = "Password must have at least one number.";
		}
		
		if (!(preg_match("#[A-Z]+#", $data['password']))) {
			$e[] = "Password must have at least one uppercase letter.";
		}
		
		if (!(preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $data['password']))) {
			$e[] = "Password must have at least one special character.";
		}
		
		if($data['security1'] == 0 || $data['security2'] == 0 || $data['security3'] == 0){
			$e[] = "You must choose all three security questions!";
		}
		
		if($data['answer1'] == '' || $data['answer2'] == '' || $data['answer3'] == ''){
			$e[] = "You cannot leave the security answers blank!";
		}
		
		if(	$data['security1'] == $data['security2'] ||
			$data['security2'] == $data['security3'] || 
			$data['security1'] == $data['security3']){
				
			$e[] = "You must choose three DIFFERENT security questions!";
		}
		
		//lets also check to make sure that the values havent been messed with
		if(!(intval($data['security1']) >= 1 &&  intval($data['security1']) <= 10)){
			// got a problem...
			$e[] = "An error occured. Please select an valid security question.";
		}
		if(!(intval($data['security2']) >= 1 &&  intval($data['security2']) <= 10)){
			// got a problem...
			$e[] = "An error occured. Please select an valid security question.";
		}
		if(!(intval($data['security3']) >= 1 &&  intval($data['security3']) <=10)){
			// got a problem...
			$e[] = "An error occured.Please select an valid security question.";
		}
		
		
		return $e;
	}
	
	function validateUpdate($data){
		$e=[];
		
		
		
		if($data['username'] == ""){
			$e[] = 'Username cannot be left blank';
		}
		
		// check if the username is the same if it is, dont invalidate it but dont allow a currently used username.
		if($data['username'] !== ""){
			if($this->userExists($data['username']) && $data['username'] != $this->username){
				$e[] = "Username " .  $data['username'] . " taken, please choose another.";
			}
		}
		/*
		if($data['password'] == ""){
			$e[] = 'password cannot be left blank';
		}
		*/
		// if the ps is blank do nothing otherwise check it.
		if($data['password'] != "") {
		
			// check if password meets requirements
			if(strlen($data['password']) < 8){
				$e[] = 'Password must have at least 8 characters';
			}
			
			if (!(preg_match("#[0-9]+#",$data['password']))) {
				$e[] = "Password must have at least one number.";
			}
			
			if (!(preg_match("#[A-Z]+#", $data['password']))) {
				$e[] = "Password must have at least one uppercase letter.";
			}
			
			if (!(preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $data['password']))) {
				$e[] = "Password must have at least one special character.";
			}
		}
		
		
		// only care about  the security questions if any of them arent zero
		if($data['security1'] == 0 || $data['security2'] == 0 || $data['security3'] == 0){
			$e[] = "You must choose all three security questions!";
		
		
			
			if($data['answer1'] == '' || $data['answer2'] == '' || $data['answer3'] == ''){
				$e[] = "You cannot leave the security answers blank!";
			}
			
			if(	$data['security1'] == $data['security2'] ||
				$data['security2'] == $data['security3'] || 
				$data['security1'] == $data['security3']){
					
				$e[] = "You must choose three DIFFERENT security questions!";
			}
			
			//lets also check to make sure that the values havent been messed with
			if(!(intval($data['security1']) >= 1 &&  intval($data['security1']) <= 10)){
				// got a problem...
				$e[] = "An error occured. Please select an valid security question.";
			}
			if(!(intval($data['security2']) >= 1 &&  intval($data['security2']) <= 10)){
				// got a problem...
				$e[] = "An error occured. Please select an valid security question.";
			}
			if(!(intval($data['security3']) >= 1 &&  intval($data['security3']) <=10)){
				// got a problem...
				$e[] = "An error occured.Please select an valid security question.";
			}
		}
		
		return $e;
	}
	
}