-- ============================================================
-- BE Opdracht 8 - Autorijschool De Komeet
-- Database create script met structuur, data en relaties
-- ============================================================

CREATE DATABASE IF NOT EXISTS komeet_rijschool
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE komeet_rijschool;

DROP TABLE IF EXISTS VoertuigInstructeur;
DROP TABLE IF EXISTS Voertuig;
DROP TABLE IF EXISTS Instructeur;
DROP TABLE IF EXISTS TypeVoertuig;

-- ------------------------------------------------------------
-- Tabel: TypeVoertuig
-- ------------------------------------------------------------
CREATE TABLE TypeVoertuig (
    Id INT NOT NULL AUTO_INCREMENT,
    TypeVoertuig VARCHAR(50) NOT NULL,
    Rijbewijscategorie VARCHAR(10) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (Id)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: Instructeur
-- ------------------------------------------------------------
CREATE TABLE Instructeur (
    Id INT NOT NULL AUTO_INCREMENT,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(20) NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Mobiel VARCHAR(15) NOT NULL,
    DatumInDienst DATE NOT NULL,
    AantalSterren TINYINT NOT NULL DEFAULT 0,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (Id)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: Voertuig
-- ------------------------------------------------------------
CREATE TABLE Voertuig (
    Id INT NOT NULL AUTO_INCREMENT,
    Kenteken VARCHAR(15) NOT NULL,
    Type VARCHAR(50) NOT NULL,
    Bouwjaar DATE NOT NULL,
    Brandstof VARCHAR(20) NOT NULL,
    TypeVoertuigId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (Id),
    UNIQUE KEY uq_voertuig_kenteken (Kenteken),
    CONSTRAINT fk_voertuig_typevoertuig
        FOREIGN KEY (TypeVoertuigId) REFERENCES TypeVoertuig (Id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: VoertuigInstructeur
-- ------------------------------------------------------------
CREATE TABLE VoertuigInstructeur (
    Id INT NOT NULL AUTO_INCREMENT,
    VoertuigId INT NOT NULL,
    InstructeurId INT NOT NULL,
    DatumToekenning DATE NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (Id),
    UNIQUE KEY uq_voertuig_instructeur (VoertuigId, InstructeurId),
    CONSTRAINT fk_vi_voertuig
        FOREIGN KEY (VoertuigId) REFERENCES Voertuig (Id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_vi_instructeur
        FOREIGN KEY (InstructeurId) REFERENCES Instructeur (Id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Testdata: TypeVoertuig
-- ------------------------------------------------------------
INSERT INTO TypeVoertuig (Id, TypeVoertuig, Rijbewijscategorie, IsActief) VALUES
(1, 'Personenauto', 'B', 1),
(2, 'Vrachtwagen', 'C', 1),
(3, 'Bus', 'D', 1),
(4, 'Bromfiets', 'AM', 1);

-- ------------------------------------------------------------
-- Testdata: Instructeur
-- ------------------------------------------------------------
INSERT INTO Instructeur (Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel, DatumInDienst, AantalSterren, IsActief) VALUES
(1, 'Li', NULL, 'Zhan', '06-28493827', '2015-04-17', 3, 1),
(2, 'Leroy', NULL, 'Boerhaven', '06-39398734', '2018-06-25', 1, 1),
(3, 'Yoeri', 'Van', 'Veen', '06-24383291', '2010-05-12', 3, 1),
(4, 'Bert', 'Van', 'Sali', '06-48293823', '2023-01-10', 4, 1),
(5, 'Mohammed', 'El', 'Yassidi', '06-34291234', '2010-06-14', 5, 1);

-- ------------------------------------------------------------
-- Testdata: Voertuig
-- Eén niet-toegewezen voertuig (Id 11) staat op non-actief voor scenario 03
-- ------------------------------------------------------------
INSERT INTO Voertuig (Id, Kenteken, Type, Bouwjaar, Brandstof, TypeVoertuigId, IsActief) VALUES
(1,  'AU-67-IO',  'Golf',      '2017-06-12', 'Diesel',     1, 1),
(2,  'TR-24-OP',  'DAF',       '2019-05-23', 'Diesel',     2, 1),
(3,  'TH-78-KL',  'Mercedes',  '2023-01-01', 'Benzine',    1, 1),
(4,  '90-KL-TR',  'Fiat 500',  '2021-09-12', 'Benzine',    1, 1),
(5,  '34-TK-LP',  'Scania',    '2015-03-13', 'Diesel',     2, 1),
(6,  'YY-OP-78',  'BMW M5',    '2022-05-13', 'Diesel',     1, 1),
(7,  'UU-HH-JK',  'M.A.N',     '2017-12-03', 'Diesel',     2, 1),
(8,  'ST-FZ-28',  'Citroën',   '2018-01-20', 'Elektrisch', 1, 1),
(9,  '123-FR-T',  'Piaggio ZIP','2021-02-01','Benzine',    4, 1),
(10, 'DRS-52-P',  'Vespa Piaggio', '2022-03-21', 'Benzine',    4, 1),
(11, 'STP-12-U',  'Kymco',     '2022-07-02', 'Benzine',    4, 0),
(12, '45-SD-23',  'Renault',   '2023-01-01', 'Diesel',     3, 1);

-- ------------------------------------------------------------
-- Testdata: VoertuigInstructeur
-- ------------------------------------------------------------
INSERT INTO VoertuigInstructeur (Id, VoertuigId, InstructeurId, DatumToekenning, IsActief) VALUES
(1, 1,  5, '2017-06-18', 1),
(2, 3,  1, '2021-09-26', 1),
(3, 9,  1, '2021-09-27', 1),
(4, 4,  4, '2022-08-01', 1),
(5, 5,  1, '2019-08-30', 1),
(6, 10, 5, '2020-02-02', 1);

-- ============================================================
-- Stored Procedures
-- ============================================================

DELIMITER $$

-- Verwijder toewijzing voertuig aan instructeur (Scenario 01)
DROP PROCEDURE IF EXISTS sp_VerwijderVoertuigVanInstructeur$$
CREATE PROCEDURE sp_VerwijderVoertuigVanInstructeur(
    IN pVoertuigId INT,
    IN pInstructeurId INT,
    OUT pResultaat VARCHAR(100)
)
BEGIN
    DECLARE vKoppelingId INT DEFAULT NULL;
    DECLARE vVoertuigActief BIT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET pResultaat = 'FOUT';
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT Id INTO vKoppelingId
    FROM VoertuigInstructeur
    WHERE VoertuigId = pVoertuigId
      AND InstructeurId = pInstructeurId
      AND IsActief = 1
    LIMIT 1;

    SELECT IsActief INTO vVoertuigActief
    FROM Voertuig
    WHERE Id = pVoertuigId
    LIMIT 1;

    IF vKoppelingId IS NULL THEN
        SET pResultaat = 'GEEN_KOPPELING';
    ELSEIF vVoertuigActief = 0 THEN
        SET pResultaat = 'NON_ACTIEF';
    ELSE
        UPDATE VoertuigInstructeur
        SET IsActief = 0,
            DatumGewijzigd = CURRENT_TIMESTAMP(6)
        WHERE Id = vKoppelingId;

        SET pResultaat = 'SUCCES';
    END IF;

    COMMIT;
END$$

-- Verwijder voertuig uit Alle voertuigen (Scenario 02 / 03)
DROP PROCEDURE IF EXISTS sp_VerwijderVoertuig$$
CREATE PROCEDURE sp_VerwijderVoertuig(
    IN pVoertuigId INT,
    OUT pResultaat VARCHAR(100)
)
BEGIN
    DECLARE vIsActief BIT DEFAULT 0;
    DECLARE vHeeftKoppeling INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET pResultaat = 'FOUT';
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT IsActief INTO vIsActief
    FROM Voertuig
    WHERE Id = pVoertuigId
    LIMIT 1;

    IF vIsActief IS NULL THEN
        SET pResultaat = 'NIET_GEVONDEN';
    ELSEIF vIsActief = 0 THEN
        SET pResultaat = 'NON_ACTIEF';
    ELSE
        SELECT COUNT(*) INTO vHeeftKoppeling
        FROM VoertuigInstructeur
        WHERE VoertuigId = pVoertuigId AND IsActief = 1;

        IF vHeeftKoppeling > 0 THEN
            UPDATE VoertuigInstructeur
            SET IsActief = 0,
                DatumGewijzigd = CURRENT_TIMESTAMP(6)
            WHERE VoertuigId = pVoertuigId AND IsActief = 1;
        END IF;

        UPDATE Voertuig
        SET IsActief = 0,
            DatumGewijzigd = CURRENT_TIMESTAMP(6)
        WHERE Id = pVoertuigId;

        SET pResultaat = 'SUCCES';
    END IF;

    COMMIT;
END$$

DELIMITER ;
