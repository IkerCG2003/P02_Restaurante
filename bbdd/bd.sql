CREATE DATABASE IF NOT EXISTS db_pr02_restaurante;
USE db_pr02_restaurante;

CREATE TABLE `user` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(50) NULL,
    email VARCHAR(60) NULL,
    pwd LONGTEXT NULL
);

CREATE TABLE `room` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NULL
);

CREATE TABLE `table` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NULL,
    capacity INT NULL,
    available BOOLEAN NULL,
    room_id INT NULL,
    user_id INT NULL,
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE `tableRegister` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    set_available BOOLEAN NULL,
    table_id INT NULL,
    user_id INT NULL,
    FOREIGN KEY (table_id) REFERENCES `table`(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);