DROP DATABASE IF EXISTS dbcpossible;
CREATE DATABASE dbcpossible;
USE dbcpossible;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS interventions;
DROP TABLE IF EXISTS interventions_candidates;


CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
password VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
role VARCHAR(255) NOT NULL,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
address VARCHAR(255),
phone_number VARCHAR(255),
birth_date DATETIME,

#volunteers
occupation VARCHAR(255),
company VARCHAR(255),
professional_background LONGTEXT,
desired_interventions TEXT,
disponibilites TEXT,
notes_admin LONGTEXT,
member BOOLEAN,
tutor BOOLEAN,
membership_fee BOOLEAN,
code_ethics BOOLEAN,
pole VARCHAR(255),

#teachers
subject VARCHAR(255),
user_id_highschool INT,

#highschools (les coordonnées first_name last_name etc sont dans ce cas celles du responsable du lycée)
highschool_name VARCHAR(255),
first_name_delegate VARCHAR(255),
last_name_delegate VARCHAR(255),
email_delegate VARCHAR(255),
phone_number_delegate VARCHAR(255),
formation TEXT,

#pole manager
poleManaged VARCHAR(255),

#Account activation and password reset
passkey VARCHAR(255),
timeout timestamp NULL DEFAULT NULL,
active BOOLEAN

);

CREATE TABLE interventions (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id_volunteer INT,
user_id_teacher INT,
asked DATETIME, #when the intervention was asked

#Status : 
#0 = demandee par prof, en attente de validation par responsable de pole 
#1 = validee, les volontaires peuvent postuler, en attente d affectation à un volontaire
#2 = affectée, en attente de réalisation
#3 = réalisée, feedback modifiable
status INT, 
section_name VARCHAR(255),
pole VARCHAR(255),
type_intervention TEXT,
#date_intervention_starts DATETIME,
#length_intervention DATETIME,
possible_dates TEXT,
date DATETIME,
length_intervention VARCHAR(255),
comment TEXT,
feedback_prof LONGTEXT,
feedback_intervenant LONGTEXT
);

CREATE TABLE interventions_candidates (
id INT AUTO_INCREMENT PRIMARY KEY,
intervention_id INT,
user_id_candidate INT,
date_candidate DATETIME
);