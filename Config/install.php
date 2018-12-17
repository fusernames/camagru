<?php

$APP->dbManager->execute('CREATE DATABASE IF NOT EXISTS camagru');
$APP->dbManager->execute('CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	role VARCHAR(255) NOT NULL DEFAULT \'user\'
)');
