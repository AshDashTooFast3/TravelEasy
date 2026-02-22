-- DROP DATABASE IF EXISTS smilepro;
-- 
-- CREATE DATABASE smilepro;

USE smilepro;

/* ======================================================
    CREATE TABLES
    ====================================================== */

CREATE TABLE Gebruiker (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,Gebruikersnaam VARCHAR(50) NOT NULL
    ,Wachtwoord VARCHAR(100) NOT NULL
    ,RolNaam VARCHAR(50) NOT NULL
    ,Email VARCHAR(255) NOT NULL
    ,Ingelogd DATETIME NOT NULL
    ,Uitgelogd DATETIME NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
);

CREATE TABLE Persoon (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,GebruikerId INT UNSIGNED NOT NULL
    ,Voornaam VARCHAR(50) NOT NULL
    ,Tussenvoegsel VARCHAR(20) NULL
    ,Achternaam VARCHAR(50) NOT NULL
    ,Geboortedatum DATE NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

CREATE TABLE Patient (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PersoonId INT UNSIGNED NOT NULL
    ,Nummer VARCHAR(20) NOT NULL
    ,MedischDossier VARCHAR(255) NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PersoonId) REFERENCES Persoon(Id)
);

CREATE TABLE Medewerker (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PersoonId INT UNSIGNED NOT NULL
    ,Nummer VARCHAR(20) NOT NULL
    ,Medewerkertype ENUM('Assistent', 'Mondhygiënist', 'Tandarts', 'Praktijkmanagement') NOT NULL
    ,Specialisatie VARCHAR(100) NULL
    ,Beschikbaarheid VARCHAR(20) NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PersoonId) REFERENCES Persoon(Id)
);

CREATE TABLE Beschikbaarheid (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,MedewerkerId INT UNSIGNED NOT NULL
    ,Datumvanaf DATE NOT NULL
    ,Datumtotmet DATE NOT NULL
    ,Tijdvanaf TIME NOT NULL
    ,Tijdtotmet TIME NOT NULL
    ,Status ENUM('Aanwezig', 'Afwezig', 'Verlof', 'Ziek') NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

CREATE TABLE Contact (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PatientId INT UNSIGNED NOT NULL
    ,Straatnaam VARCHAR(100) NOT NULL
    ,Huisnummer VARCHAR(10) NOT NULL
    ,Toevoeging VARCHAR(10) NULL
    ,Postcode VARCHAR(10) NOT NULL
    ,Plaats VARCHAR(50) NOT NULL
    ,Mobiel VARCHAR(20) NULL
    ,Email VARCHAR(100) NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PatientId) REFERENCES Patient(Id)
);

CREATE TABLE Afspraken (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PatientId INT UNSIGNED NOT NULL
    ,MedewerkerId INT UNSIGNED NOT NULL
    ,Datum DATE NOT NULL
    ,Tijd TIME NOT NULL
    ,Status ENUM('Bevestigd', 'Geannuleerd') NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PatientId) REFERENCES Patient(Id)
    ,FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

CREATE TABLE Behandeling (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,MedewerkerId INT UNSIGNED NOT NULL
    ,PatientId INT UNSIGNED NOT NULL
    ,Datum DATE NOT NULL
    ,Tijd TIME NOT NULL
    ,Behandelingtype ENUM('Controles', 'Vullingen', 'Gebitsreiniging', 'Orthodontie', 'Wortelkanaalbehandelingen') NOT NULL
    ,Omschrijving VARCHAR(255) NULL
    ,Kosten DECIMAL(10,2) NOT NULL
    ,Status ENUM('Behandeld', 'Onbehandeld', 'Uitgesteld') NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
    ,FOREIGN KEY (PatientId) REFERENCES Patient(Id)
);

CREATE TABLE Factuur (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PatientId INT UNSIGNED NOT NULL
    ,BehandelingId INT UNSIGNED NOT NULL
    ,Nummer VARCHAR(20) NOT NULL
    ,Datum DATE NOT NULL
    ,Bedrag DECIMAL(10,2) NOT NULL
    ,Status ENUM('Verzonden', 'Niet-Verzonden', 'Betaald', 'Onbetaald') NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PatientId) REFERENCES Patient(Id)
    ,FOREIGN KEY (BehandelingId) REFERENCES Behandeling(Id)
);

CREATE TABLE Communicatie (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PatientId INT UNSIGNED NOT NULL
    ,MedewerkerId INT UNSIGNED NOT NULL
    ,Bericht VARCHAR(255) NOT NULL
    ,VerzondenDatum DATETIME NOT NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PatientId) REFERENCES Patient(Id)
    ,FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

CREATE TABLE Feedback (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PatientId INT UNSIGNED NOT NULL
    ,Beoordeling INT NOT NULL
    ,praktijkEmail VARCHAR(100) NULL
    ,praktijkTelefoon VARCHAR(20) NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PatientId) REFERENCES Patient(Id)
);

/* ======================================================
    INSERTS
    ====================================================== */

-- Gebruiker
INSERT INTO Gebruiker (Id,Gebruikersnaam,Wachtwoord,RolNaam,Ingelogd,Uitgelogd,Isactief,Email,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,'tandarts','achraf123','Tandarts',SYSDATE(6),SYSDATE(6),1,'tandarts@smilepro.nl',NULL,SYSDATE(6),SYSDATE(6)),
(2,'mondhygiënist','achraf123','Mondhygiënist',SYSDATE(6),SYSDATE(6),1,'mondhygiënist@smilepro.nl',NULL,SYSDATE(6),SYSDATE(6)),
(3,'assistent','achraf123','Assistent',SYSDATE(6),SYSDATE(6),1,'assistent@smilepro.nl',NULL,SYSDATE(6),SYSDATE(6)),
(4,'praktijkmanagement','achraf123','Praktijkmanagement',SYSDATE(6),SYSDATE(6),1,'praktijkmanagement@smilepro.nl',NULL,SYSDATE(6),SYSDATE(6)),
(5,'patient','achraf123','Patient',SYSDATE(6),SYSDATE(6),1,'patient@smilepro.nl',NULL,SYSDATE(6),SYSDATE(6));
-- Persoon
INSERT INTO Persoon (Id,GebruikerId,Voornaam,Tussenvoegsel,Achternaam,Geboortedatum,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,'Jan',NULL,'Jansen','1980-04-12',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,'Peter','de','Vries','1975-11-02',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,'Linda',NULL,'Boer','1990-07-18',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,'Klaas',NULL,'Klaassen','2001-03-09',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,'Marieke',NULL,'Meijer','1998-12-22',1,NULL,SYSDATE(6),SYSDATE(6));

-- Patient
INSERT INTO Patient (Id,PersoonId,Nummer,MedischDossier,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,3,'P1001','Allergisch voor latex',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,4,'P1002','Geen bijzonderheden',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,5,'P1003','Eerdere wortelkanaalbehandeling',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,'P1004','Angst voor tandarts',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,'P1005','Allergisch voor verdoving',1,NULL,SYSDATE(6),SYSDATE(6));

-- Medewerker
INSERT INTO Medewerker (Id,PersoonId,Nummer,Medewerkertype,Specialisatie,Beschikbaarheid,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,'M2001','Tandarts','Orthodontie','Ma–Vr 09:00–17:00',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,'M2002','Tandarts','Implantologie','Ma–Vr 08:00–16:00',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,'M2003','Assistent','N.V.T.','Ma–Do 10:00–18:00',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,1,'M2004','Praktijkmanagement','Administratie','Ma–Vr 09:00–15:00',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,2,'M2005','Mondhygiënist','Gebitsreiniging','Di–Za 09:00–17:00',1,NULL,SYSDATE(6),SYSDATE(6));

-- Beschikbaarheid
INSERT INTO Beschikbaarheid (Id,MedewerkerId,Datumvanaf,Datumtotmet,Tijdvanaf,Tijdtotmet,Status,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,'2025-01-10','2025-01-10','09:00','17:00','Aanwezig',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,'2025-01-11','2025-01-11','08:00','16:00','Aanwezig',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,'2025-01-12','2025-01-12','10:00','18:00','Aanwezig',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,1,'2025-01-13','2025-01-13','09:00','17:00','Verlof',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,2,'2025-01-14','2025-01-14','08:00','16:00','Ziek',1,NULL,SYSDATE(6),SYSDATE(6));

-- Contact
INSERT INTO Contact (Id,PatientId,Straatnaam,Huisnummer,Toevoeging,Postcode,Plaats,Mobiel,Email,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,'Dorpsstraat','10',NULL,'1234AB','Amsterdam','0612345678','p1@mail.com',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,'Laanweg','22','A','2345BC','Rotterdam','0623456789','p2@mail.com',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,'Marktplein','5',NULL,'3456CD','Utrecht',NULL,'p3@mail.com',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,'Stationsweg','99','B','4567DE','Eindhoven','0634567890','p4@mail.com',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,'Kerkstraat','3',NULL,'5678EF','Haarlem',NULL,'p5@mail.com',1,NULL,SYSDATE(6),SYSDATE(6));

-- Afspraken
INSERT INTO Afspraken (Id,PatientId,MedewerkerId,Datum,Tijd,Status,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,1,'2025-02-01','09:00','Bevestigd',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,2,'2025-02-02','10:00','Bevestigd',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,3,'2025-02-03','11:00','Geannuleerd',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,1,'2025-02-04','14:00','Bevestigd',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,2,'2025-02-05','15:00','Bevestigd',1,NULL,SYSDATE(6),SYSDATE(6));

-- Behandeling
INSERT INTO Behandeling (Id,MedewerkerId,PatientId,Datum,Tijd,Behandelingtype,Omschrijving,Kosten,Status,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,1,'2025-02-01','09:00','Controles','Periodieke controle',45.00,'Behandeld',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,2,'2025-02-02','10:00','Vullingen','Gaatje gevuld',85.00,'Behandeld',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,3,'2025-02-03','11:00','Gebitsreiniging','Reiniging uitgevoerd',65.00,'Behandeld',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,1,4,'2025-02-04','14:00','Orthodontie','Beugelcontrole',120.00,'Uitgesteld',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,2,5,'2025-02-05','15:00','Wortelkanaalbehandelingen','Kanaal gereinigd',350.00,'Onbehandeld',1,NULL,SYSDATE(6),SYSDATE(6));

-- Factuur
INSERT INTO Factuur (Id,PatientId,BehandelingId,Nummer,Datum,Bedrag,Status,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,1,'F2025001','2025-02-02',45.00,'Verzonden',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,2,'F2025002','2025-02-03',85.00,'Betaald',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,3,'F2025003','2025-02-04',65.00,'Onbetaald',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,4,'F2025004','2025-02-05',120.00,'Niet-Verzonden',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,5,'F2025005','2025-02-06',350.00,'Verzonden',1,NULL,SYSDATE(6),SYSDATE(6));

-- Communicatie
INSERT INTO Communicatie (Id,PatientId,MedewerkerId,Bericht,VerzondenDatum,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,1,'Herinnering afspraak','2025-01-20',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,2,'Bevestiging afspraak','2025-01-21',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,3,'Behandeling rapport','2025-01-22',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,1,'Annulering melding','2025-01-23',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,2,'Betalingsherinnering','2025-01-24',1,NULL,SYSDATE(6),SYSDATE(6));

-- Feedback
INSERT INTO Feedback (Id,PatientId,Beoordeling,praktijkEmail,praktijkTelefoon,Isactief,Opmerking,Datumaangemaakt,Datumgewijzigd) VALUES
(1,1,5,'info@praktijk.nl','0201234567',1,NULL,SYSDATE(6),SYSDATE(6)),
(2,2,4,'info@praktijk.nl','0201234567',1,NULL,SYSDATE(6),SYSDATE(6)),
(3,3,3,'info@praktijk.nl','0201234567',1,NULL,SYSDATE(6),SYSDATE(6)),
(4,4,5,'info@praktijk.nl','0201234567',1,NULL,SYSDATE(6),SYSDATE(6)),
(5,5,4,'info@praktijk.nl','0201234567',1,NULL,SYSDATE(6),SYSDATE(6));
