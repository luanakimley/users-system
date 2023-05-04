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
    user_type ENUM("user", "administrator") NOT NULL,
    photo_file_path VARCHAR(255),
    birth_date DATE NOT NULL,
    is_active BOOLEAN NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE(email)
);