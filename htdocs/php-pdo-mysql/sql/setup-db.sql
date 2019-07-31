--
-- Setup for the article:
-- https://dbwebb.se/kunskap/kom-igang-med-php-pdo-och-mysql
--

--
-- Create the database with a test user
--
CREATE DATABASE IF NOT EXISTS oophp;
DROP USER IF EXISTS 'user'@'%';
CREATE USER IF NOT EXISTS 'user'@'%'
    IDENTIFIED WITH mysql_native_password
    BY 'pass'
;

GRANT ALL PRIVILEGES
ON oophp.*
TO 'user'@'%'
;
USE oophp;
-- Skapa användaren med en bakåtkompatibel lösenordsalgoritm.
