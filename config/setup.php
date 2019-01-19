<?php

$APP->pdo->query('CREATE DATABASE IF NOT EXISTS camagru');
$APP->pdo->query('CREATE TABLE IF NOT EXISTS user (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	role VARCHAR(255) NOT NULL DEFAULT \'user\',
	hash VARCHAR(255) NOT NULL,
	active INT(11) NOT NULL DEFAULT 0
)');
$APP->pdo->query('CREATE TABLE IF NOT EXISTS picture (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_user INT NOT NULL,
	filename VARCHAR(255) NOT NULL,
	description VARCHAR(5000) DEFAULT NULL,
	creation_date TIMESTAMP NOT NULL,
	FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE
)');
$APP->pdo->query('CREATE TABLE IF NOT EXISTS picture_comment (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_user INT NOT NULL,
	id_picture INT NOT NULL,
	comment VARCHAR(5000) NOT NULL,
	creation_date TIMESTAMP NOT NULL,
	nb_likes INT NOT NULL DEFAULT 0,
	FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
	FOREIGN KEY (id_picture) REFERENCES picture(id) ON DELETE CASCADE
)');
$APP->pdo->query('CREATE TABLE IF NOT EXISTS picture_comment_like (
	id INT AUTO_INCREMENT PRIMARY KEY,
	id_user INT NOT NULL,
	id_comment INT NOT NULL,
	FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE,
	FOREIGN KEY (id_comment) REFERENCES picture_comment(id) ON DELETE CASCADE
)');
/*
$APP->pdo->query('CREATE TRIGGER IF NOT EXISTS inc_nb_comments AFTER INSERT ON picture_comment_like
FOR EACH ROW
BEGIN
	UPDATE picture_comment SET nb_likes = nb_likes + 1 WHERE id = NEW.id_comment;
END');
*/
