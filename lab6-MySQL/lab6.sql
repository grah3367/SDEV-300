use sdev300;

-- 1
-- Create a table named Faculty to store EMPLID, first name, last name, email, and
-- year of birth, and Hire date. You should select the appropriate data types, sizes and
-- constraints for the table.
CREATE TABLE Faculty (
EMPLID int primary key AUTO_INCREMENT,
FirstName varchar(30),
LastName varchar(30),
Email varchar(60),
YearOfBirth int,
HireDate DATE
);

-- 2
-- Create a table named Courses to store CourseID, discipline name (e.g. SDEV), course
-- number (e.g. 300), number of credits (e.g. 3), date first offered (e.g. June 10, 2010)
-- and course title. You should select the appropriate data types, sizes and constraints
-- for the table. (

CREATE TABLE Courses(
CourseID int primary key AUTO_INCREMENT,
DateOffered DATE,
CourseDisc varchar(4),
CourseNum SMALLINT,
CourseTitle varchar(75),
Credits tinyint
);

-- 3
-- Create a table named FacultyCourses to store the Faculty and the Courses they
-- have taught. You should design the table based on the Faculty and Courses tables
-- you previously created.
CREATE TABLE FacultyCourses (
FacultyCourseID int primary key AUTO_INCREMENT,
EMPLID int,
CourseID int,
Constraint FK_FacultyCourses Foreign Key (CourseID) references Courses(CourseID) on delete cascade,
Constraint FK_EMPLIDS Foreign Key (EMPLID) references Faculty(EMPLID) on delete cascade
);

-- 4
-- Create Insert statements to populate at least 20 faculty records, 20 Course records,
-- and 25 FacultyCourses records.
insert into Faculty (FirstName, LastName, Email, YearOfBirth, HireDate)
VALUES ('Marilyn','Gibson','MarilynJGibson@faculty.umuc.edu', '1983','2009-05-02'),
       ('Harold','Lindsey','HaroldMLindsey@faculty.umuc.edu', '1978','2010-04-06'),
       ('Keith','Petersen','KeithBPetersen@faculty.umuc.edu', '1980', '2009-12-22'),
       ('Janice','Wright','JaniceRWright@faculty.umuc.edu', '1971','2016-05-24'),
       ('Christine','Riley','ChristineBRiley@faculty.umuc.edu', '1987','2015-11-13'),
       ('Theresa','Jaimes','TheresaJJaimes@faculty.umuc.edu','1952','1988-10-24'),
       ('Peggie','Lowe','PeggieMLowe@faculty.umuc.edu', '1977','1990-03-03'),
       ('Sandra','Harvey','SandraJHarvey@faculty.umuc.edu', '1989','2001-07-20'),
       ('Betty','Mace','BettySMace@faculty.umuc.edu', '1988','2012-04-01'),
       ('William','Taylor','WilliamLTaylor@faculty.umuc.edu', '1991','2016-06-30'),
       ('Brett','Pettiford','BrettCPettiford@faculty.umuc.edu', '1973','1998-02-13'),
       ('Teresa ','Cruz','TeresaPCruz@faculty.umuc.edu', '1975','2001-06-15'),
       ('Joseph','Tyson','JosephMTyson@faculty.umuc.edu', '1976','2003-08-03'),
       ('Richard','Cruz','RichardMCruz@faculty.umuc.edu', '1981','2003-09-28'),
       ('Justine','Jacobsen','JustineGJacobsen@faculty.umuc.edu', '1970','1990-09-15'),
       ('Ada','Adams','AdaIAdams@faculty.umuc.edu', '1988','1982-10-28'),
       ('Joey','Sawyer','JoeyPSawyer@faculty.umuc.edu', '1988','2018-04-04'),
       ('Melissa','Brown','MelissaRBrown@faculty.umuc.edu', '1987','2015-11-13'),
       ('Michell','Budd','MichellJBudd@faculty.umuc.edu', '1970','2009-06-18'),
       ('Michael','Jamison','MichaelNJamison@faculty.umuc.edu', '1977','2005-03-03'),
       ('Stephen','Segers','StephenBSegers@faculty.umuc.edu', '1983','2017-05-02');
       
insert into Courses (DateOffered, CourseDisc, CourseNum, CourseTitle, Credits)
VALUES ('2002-05-02', 'SDEV', '300', 'Building Secure Web Applications', '3'),
	   ('2004-05-02', 'SDEV', '325', 'Detecting Software Vulnerabilities', '3'),
       ('2001-05-02', 'SDEV', '350', 'Database Security', '3'),
       ('2008-05-02', 'SDEV', '355', 'Securing Mobile Apps', '3'),
       ('2009-05-02', 'SDEV', '360', 'Secure Software Engineering', '3'),
       ('2005-05-02', 'SDEV', '400', 'Secure Programming in the Cloud', '3'),
       ('2007-05-02', 'SDEV', '425', 'Mitigating Software Vulnerabilities', '3'),
       ('2004-05-02', 'CMSC', '150', 'Introduction to Discrete Structures', '3'),
       ('2009-05-02', 'CMSC', '325', 'Game Design and Development', '3'),
       ('2009-05-02', 'CMSC', '330', 'Advanced Programming Languages', '3'),
       ('2008-05-02', 'CMSC', '335', 'Object-Oriented and Concurrent Programming', '3'),
       ('2009-05-02', 'CMSC', '350', 'Data Structures and Analysis', '3'),
       ('2007-05-02', 'CMSC', '405', 'Computer Graphics', '3'),
       ('2009-05-02', 'CMSC', '412', 'Operating Systems', '3'),
       ('2009-05-02', 'CMSC', '430', 'Compiler Theory and Design', '3'),
       ('2009-05-02', 'CMSC', '451', 'Design and Analysis of Computer Algorithms', '3'),
       ('2002-05-02', 'CMIS', '141', 'Introductory Programming', '3'),
       ('2001-05-02', 'CMIS', '242', 'Intermediate Programming', '3'),
       ('2007-05-02', 'CMIS', '310', 'Computer Systems and Architecture', '3'),
       ('2009-05-02', 'CMIS', '320', 'Relational Database Concepts and Applications', '3');

insert into FacultyCourses (EMPLID ,CourseID)
VALUES(1,2),
	  (2,4),
      (2,19),
      (2,16),
      (3,5),
      (4,7),
      (5,4),
      (6,15),
      (7,12),
      (8,11),
      (9,18),
      (10,17),
      (11,19),
      (12,20),
      (13,9),
      (14,8),
      (15,6),
      (16,18),
      (17,1),
      (18,3),
      (19,7),
      (20,10),
      (21,14);
      
--  5
-- Create an update statement to update all Courses to 6 credits.
update Courses set Credits = '6';

-- 6
-- Create an update statement to update any Faculty with a year of birth of 1994 to
-- change it to 1993.
update Faculty set YearOfBirth = '1993' where YearOfBirth = '1994';
       
-- 7
-- Write an appropriate SQL statement to delete any Faculty record whose Last name
-- starts with the letter ‘R’ or the letter ‘S’.
delete from Faculty where LastName like 'B%' or LastName like 'S%';

-- 8 
-- Write an appropriate SQL statement to delete any Course record that was first
-- offered in 2004.
delete from Courses where DateOffered >= '2004-01-01' and DateOffered <= '2004-12-31';

-- 9
-- Use appropriate select statements to display all records in all 3 tables. The Faculty
-- query should display the Faculty by last name in descending order and Course query
-- should display the courses in ascending order by course title. The display order of
-- the FacultyCourses table is not specified.
select * from Faculty order by LastName desc; 
select * from Courses order by CourseTitle asc;
select * from FacultyCourses;

-- 10
-- Create a select statement to display all Faculty who have not taught at least 3 courses.
select EMPLID from FacultyCourses group by EMPLID having count(*) < 3;

-- 11
--  Create a select statement to display all Courses offered before 1999.
select * from Courses where DateOffered <= '2011-01-01';

-- 12
-- Use select and appropriate joins to display all columns from the Faculty and Course tables for
-- each Faculty and Course in the FacultyCourse table. Note: this will be a 3-table join.
select * from Faculty F, Courses C, FacultyCourses FC where F.EMPLID = FC.EMPLID and C.CourseID = FC.CourseID;
