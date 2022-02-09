/*Removing if exists & creation*/
DROP DATABASE IF EXISTS `db_my_meetic`;
CREATE DATABASE `db_my_meetic`;

/*CREATING TABLES*/
CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT, 
    `nom` VARCHAR(50) NOT NULL,
    `prenom` VARCHAR(50) NOT NULL,
    `date_de_naissance` DATE NOT NULL,
    `genre` VARCHAR(10) NOT NULL,
    `ville` VARCHAR(150) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `mot_de_passe_hash` VARCHAR(255) NOT NULL,
    `loisirs` VARCHAR(150) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;