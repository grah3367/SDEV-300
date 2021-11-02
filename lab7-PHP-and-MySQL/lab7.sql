CREATE SCHEMA IF NOT EXISTS `lab7` DEFAULT CHARACTER SET utf8;


CREATE TABLE IF NOT EXISTS securityAnswer (
	answerId int NOT NULL AUTO_INCREMENT,
	userid int NOT NULL,
	questionId int NOT NULL,
	answer varchar(255) NOT NULL,
	PRIMARY KEY (answerId),
	CONSTRAINT FK_QuestionUser FOREIGN KEY (userid)
	REFERENCES users(idusers) ON DELETE CASCADE,
	CONSTRAINT FK_AnswerQuestion FOREIGN KEY (questionId)
	REFERENCES securityQuestions(idsecurityQuestions) ON DELETE CASCADE
	
);

CREATE TABLE IF NOT EXISTS `lab7`.`securityQuestions` (
  `idsecurityQuestions` INT NOT NULL,
  `question` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`idsecurityQuestions`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `lab7`.`users` (
  `idusers` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL NOT NULL,
  `password` VARCHAR(255) NULL NOT NULL,
  `highScore` INT NULL,
  PRIMARY KEY (`idusers`))
ENGINE = InnoDB;

-- create the users`
--create an owner user for specific access to this project's database
GRANT ALL PRIVILEGES ON *.* TO lab7_owner@localhost IDENTIFIED BY PASSWORD 'ownerPass';

-- create the app user and only allow update/delete to tables it needs, only read access to securityQuestions
GRANT ALL PRIVILEGES ON `lab7.users TO lab7@localhost IDENTIFIED BY PASSWORD 'lab7pass';
GRANT ALL PRIVILEGES ON `securityAnswer` TO lab7@localhost;
GRANT SELECT ON `securityQuestions` TO lab7@localhost;



INSERT INTO `securityQuestions` (idsecurityQuestions, question)
VALUES (1,'What is your oldest sibling’s birthday month and year? '),
       (2,'What is the first name of your best friend in high school?'),
	   (3,'Who was your childhood hero? '),
	   (4,'What is your mothers surname?'),
	   (5,'Where were you when you first heard about 9/11? '),
	   (6,'What was the last name of your third grade teacher?'),
	   (7,'Where was your first job?'),
	   (8,'Who is your favorite actor, musician, or artist?'),
	   (9,'What is the name of a college you applied to but did not attend?'),
	   (10, 'What is your favorite movie?');