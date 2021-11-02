<?php
class Game {
	
	private static $instance;
	private $currentScore;
	private $gameAnswer;
	private $highScore;
	private $bestPlayerScore;
	private $bestPlayerName;
	
	
	function __construct(){
		
		$this->setCurrentScore();
		$this->setAnswer();
		$this->setHighScore();
		$this->getHighScores();
		$this->getBestPlayer();
		
	}
	
	public static function getInstance(){
		 if (! self::$instance) {
            self::$instance = new self();
        }
		return self::$instance;
	}
	
	function setAnswer(){
		if(isset($_SESSION['answer'])){
			$this->gameAnswer = $_SESSION['answer'];
		}
	}
	function setHighScore(){
		if(isset($_SESSION['highScore'])){
			$this->highScore = $_SESSION['highScore'];
		}
	}
	
	function setCurrentScore(){
		if(isset($_SESSION['currentScore'])){
			$this->currentScore = $_SESSION['currentScore'];
		} else {
		$this->currentScore=0;
		}
	}
	
	function getHighScore(){
		return $this->highScore;
	}
	
	function setBestPlayer(){
		if(isset($_SESSION['bestPlayerScore'])){
			$this->bestPlayerScore = $_SESSION['bestPlayerScore'];
		}
		if(isset($_SESSION['bestPlayerName'])){
			$this->bestPlayername = $_SESSION['bestPlayerName'];
		}
		
	}
	
	function getBestPlayerScore(){
		return $this->bestPlayerScore;
	}
	function getBestPlayerName(){
		return $this->bestPlayername;
	}
	
	
	function getCurrentScore(){
		return $this->currentScore;
	}
	
	function getHighScores(){
		$user = user::getInstance();
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$stmt = $mysqli->prepare("SELECT highScore from users WHERE idusers=? LIMIT 1");
		$userid = $user->getUserId();
		$stmt->bind_param("s", $userid);
		$stmt->execute();
		
		$stmt->bind_result($rhighScore);
		
		$stmt->store_result();
		$result = $stmt->fetch();
		$numRows = $stmt->num_rows;
		
		
		if($result && !empty($result) && $numRows == 1) {
			// we have a result
			$_SESSION['highScore'] = $rhighScore;
			$this->setHighScore();
			
		}else{
			$e[] = "There was a problem.";
		}
		
	}
	
	function getBestPlayer(){
	
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$stmt = $mysqli->prepare("SELECT username,highScore from users where highScore=(SELECT MAX(highScore) FROM users) LIMIT 1");

		$stmt->execute();
		
		$stmt->bind_result($bestPlayerName,$bestPlayerScore);
		
		$stmt->store_result();
		$result = $stmt->fetch();
		$numRows = $stmt->num_rows;
		
		
		if($result && !empty($result) && $numRows == 1) {
			// we have a result
			$_SESSION['bestPlayerName'] = $bestPlayerName;
			$_SESSION['bestPlayerScore'] = $bestPlayerScore;
			$this->setBestPlayer();
			
		}else{
			$e[] = "There was a problem.";
		}
	}
	
	
	
	function getRandomGameQuestion(){
		
		// create a random question
		$question = "What is ";
		$num1 = rand(0,100);
		$num2 = rand(0,100);
		$operation = " + ";
		$question = $num1 . $operation . $num2 . " ?";
		$answer = $num1 + $num2;
		$_SESSION['answer'] = $answer;
		$this->setAnswer();
		
		return $question;
		
	}
	
	function quitCurrentGame(){
		//we need to save the score and reset it.
		//if the currentScore is the highest
		if($this->currentScore > $this->highScore){
			$this->saveScore($this->currentScore);
			
		}
		
		$_SESSION['currentScore']=0;
		$this->setCurrentScore();
	}
	
	function saveScore($score){
		$user = user::getInstance();
		$db = dbConnect::getInstance();
		$mysqli = $db->getConnection();
		
		$stmt = $mysqli->prepare("UPDATE users SET highScore=? WHERE idusers=? LIMIT 1");
		$userid = $user->getUserId();
		
		$stmt->bind_param("is", $score, $userid);
		$stmt->execute();
	}
	
	function checkGameAns($answer){
		
		if($answer == ''){
			
			$_SESSION['currentScore'] = $this->currentScore - 5;
			return $r = "you have to enter an answer!  -5 points.";
		}
		
		if(intval($answer) == intval($this->gameAnswer)){
			// you got it right
			$r = "You're right! +10 points.";
			$_SESSION['currentScore'] = $this->currentScore + 10;
		} else {
			$r = "Sorry you got it wrong. -10 points. try another.";
			$_SESSION['currentScore'] = $this->currentScore - 10;	
		}
		$this->setCurrentScore();
		return $r;
	}
}

?>