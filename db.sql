/*
	****************** USERS SYSTEM *******************
*/

/*-----------------------------------------------------------------CREATES-------------------------------------------------------------------------------------*/
CREATE DATABASE IF NOT EXISTS users_system DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE users_system;

DROP TABLE IF EXISTS users;

/*CREATE users table*/
CREATE TABLE users 
(
    user_id INT(4) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    user_password VARCHAR(200) NOT NULL,
    user_type ENUM("user", "manager") NOT NULL,
    photo_file_path VARCHAR(255),
    birth_date DATE NOT NULL,
    is_active TINYINT(1) NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE(email)
);

/*-----------------------------------------------------------------INSERTIONS-------------------------------------------------------------------------------------*/


/*INSERTS data INTO the users table*/
INSERT INTO users (user_name, email, user_password, user_type, photo_file_path, birth_date, is_active) VALUES
("Luana", "luanakimley@gmail.com", "12345", "manager", "", "2002-08-27", 1),
("Niall", "niall.blackrock@gmail.com", "12467", "user", "", "2001-06-11", 1);