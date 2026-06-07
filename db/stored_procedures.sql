-- Stored Procedures voor BE Opdracht 8
-- Onderdeel van db/create.sql - apart bestand voor documentatie

USE komeet_rijschool;

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_VerwijderVoertuigVanInstructeur$$
CREATE PROCEDURE sp_VerwijderVoertuigVanInstructeur(
    IN pVoertuigId INT,
    IN pInstructeurId INT,
    OUT pResultaat VARCHAR(100)
)
BEGIN
    -- Zie db/create.sql voor volledige implementatie
END$$

DROP PROCEDURE IF EXISTS sp_VerwijderVoertuig$$
CREATE PROCEDURE sp_VerwijderVoertuig(
    IN pVoertuigId INT,
    OUT pResultaat VARCHAR(100)
)
BEGIN
    -- Zie db/create.sql voor volledige implementatie
END$$

DELIMITER ;
