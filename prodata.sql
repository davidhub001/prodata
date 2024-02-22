-- prodata.sql

-- Table des clients
CREATE TABLE IF NOT EXISTS wp_clients (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    nom varchar(255) NOT NULL,
    prenom varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    telephone varchar(15) NOT NULL,
    photo varchar(255) NOT NULL,
    couverture varchar(255) NOT NULL,
    groupe_id mediumint(9),
    PRIMARY KEY  (id)
) DEFAULT CHARSET=utf8mb4;

-- Table des groupes (ajoutez cette partie si nécessaire)
CREATE TABLE IF NOT EXISTS wp_groupes (
    groupe_id mediumint(9) NOT NULL AUTO_INCREMENT,
    nom_groupe varchar(255) NOT NULL,
    PRIMARY KEY  (groupe_id)
) DEFAULT CHARSET=utf8mb4;
