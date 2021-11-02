-- Run as root

create database tutors;

-- Password is tutorville
-- Set-up privileges
-- Not a good practice to grant all privileges for WebApp user.
-- The SDEV Secure DB course will provide better approaches
Grant All Privileges on *.* to tutors_owner@localhost Identified by Password '*EB2BC30085F40F80205FE66591CF633D1BCE409E';

