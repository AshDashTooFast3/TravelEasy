-- =====================================================
-- DATABASE
-- =====================================================
DROP DATABASE IF EXISTS TravelEasy;
CREATE DATABASE TravelEasy;
USE TravelEasy;

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
 
-- =====================================================
-- TABEL: Passagier
-- =====================================================
CREATE TABLE Passagier (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
   ,PersoonId INT UNSIGNED NOT NULL
   ,Nummer INT NOT NULL
   ,PassagierType VARCHAR (100) NOT NULL
   ,IsActief BIT NOT NULL DEFAULT 1
   ,Opmerking VARCHAR(225) NULL
   ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
   ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
) ENGINE=InnoDB;
 
 CREATE TABLE Medewerker (
     Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PersoonId INT UNSIGNED NOT NULL
    ,Nummer VARCHAR(20) NOT NULL
    ,Medewerkertype VARCHAR(255) NOT NULL
    ,Specialisatie VARCHAR(100) NULL
    ,Beschikbaarheid VARCHAR(20) NULL
    ,Isactief BIT NOT NULL
    ,Opmerking VARCHAR(255) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PersoonId) REFERENCES Persoon(Id)
);
 
-- =====================================================
-- TABEL: Vertrek
-- =====================================================
CREATE TABLE Vertrek (
     Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,Land VARCHAR(50) NOT NULL
    ,Luchthaven VARCHAR(20) NOT NULL
    ,IsActief BIT NOT NULL DEFAULT 1
    ,Opmerking VARCHAR(225) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
) ENGINE=InnoDB;
 
-- =====================================================
-- TABEL: Bestemming
-- =====================================================
CREATE TABLE Bestemming (
     Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,Land VARCHAR(50) NOT NULL
    ,Luchthaven VARCHAR(20) NOT NULL
    ,IsActief BIT NOT NULL DEFAULT 1
    ,Opmerking VARCHAR(225) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
) ENGINE=InnoDB;
 
-- =====================================================
-- TABEL: Vlucht
-- =====================================================
CREATE TABLE Vlucht (
     Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,VertrekId INT UNSIGNED NOT NULL
    ,BestemmingId INT UNSIGNED NOT NULL
    ,Vluchtnummer VARCHAR(5) NOT NULL
    ,Vertrekdatum DATE NOT NULL
    ,Vertrektijd TIME NOT NULL
    ,Aankomstdatum DATE NOT NULL
    ,Aankomsttijd TIME NOT NULL
    ,Vluchtstatus VARCHAR(20) NOT NULL
    ,IsActief BIT NOT NULL DEFAULT 1
    ,Opmerking VARCHAR(225) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (VertrekId) REFERENCES Vertrek(Id)
    ,FOREIGN KEY (BestemmingId) REFERENCES Bestemming(Id)
) ENGINE=InnoDB;

CREATE TABLE Accommodatie (
     Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,VluchtId INT UNSIGNED NOT NULL
    ,Naam VARCHAR(255) NOT NULL
    ,Type VARCHAR(100) NOT NULL
    ,Straat VARCHAR(255) NOT NULL
    ,Huisnummer VARCHAR(10) NOT NULL
    ,Toevoeging VARCHAR(5) NULL
    ,Postcode VARCHAR(20) NOT NULL
    ,Stad VARCHAR(100) NOT NULL
    ,Land VARCHAR(100) NOT NULL
    ,CheckInDatum DATE NOT NULL
    ,CheckOutDatum DATE NOT NULL
    ,AantalKamers TINYINT DEFAULT 1
    ,AantalPersonen SMALLINT
    ,PrijsPerNacht DECIMAL(10,2)
    ,TotaalPrijs DECIMAL(10,2)
    ,IsActief BIT NOT NULL DEFAULT 1
    ,Opmerking VARCHAR(225) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (VluchtId) REFERENCES Vlucht(Id)
) ENGINE=InnoDB;

CREATE TABLE Boeking (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
   ,PassagierId INT UNSIGNED NOT NULL
   ,VluchtId INT UNSIGNED NOT NULL
   ,Boekingsnummer VARCHAR(20) NOT NULL
   ,Boekingsdatum DATE NOT NULL
   ,Boekingstijd TIME NOT NULL
   ,Boekingsstatus VARCHAR(20) NOT NULL
   ,TotaalPrijs DECIMAL(10,2) NOT NULL
   ,IsActief BIT NOT NULL DEFAULT 1
   ,Opmerking VARCHAR(225) NULL
   ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
   ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
   ,FOREIGN KEY (PassagierId) REFERENCES Passagier(Id)
   ,FOREIGN KEY (VluchtId) REFERENCES Vlucht(Id)
) ENGINE=InnoDB;
 
-- =====================================================
-- TABEL: Ticket
-- =====================================================
CREATE TABLE Ticket (
     Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,PassagierId INT UNSIGNED NOT NULL
    ,VluchtId INT UNSIGNED NOT NULL
    ,Stoelnummer VARCHAR(4) NOT NULL
    ,Aankoopdatum DATE NOT NULL
    ,Aankooptijd TIME NOT NULL
    ,Prijs DECIMAL(6,2) NOT NULL
    ,Aantal TINYINT NOT NULL
    ,Btw TINYINT NOT NULL DEFAULT 21
    ,BedragIncBtw DECIMAL(8,2) AS (Prijs * Aantal * (1 + (Btw / 100.0))) STORED
    ,IsActief BIT NOT NULL DEFAULT 1
    ,Opmerking VARCHAR(225) NULL
    ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
    ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
    ,FOREIGN KEY (PassagierId) REFERENCES Passagier(Id)
    ,FOREIGN KEY (VluchtId) REFERENCES Vlucht(Id)
) ENGINE=InnoDB;
 
CREATE TABLE Factuur (
    Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
   ,TicketId INT UNSIGNED NOT NULL
   ,Factuurnummer VARCHAR(20) NOT NULL
   ,Factuurdatum DATE NOT NULL
   ,Factuurtijd TIME NOT NULL
   ,TotaalBedrag DECIMAL(10,2) NOT NULL
   ,Betaalstatus VARCHAR(20) NOT NULL
   ,Betaalmethode VARCHAR(50) NULL
   ,IsActief BIT NOT NULL DEFAULT 1
   ,Opmerking VARCHAR(225) NULL
   ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
   ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
   ,FOREIGN KEY (TicketId) REFERENCES Ticket(Id)
) ENGINE=InnoDB;
 
 
