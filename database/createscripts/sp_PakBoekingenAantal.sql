USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_PakBoekingenAantal;

DELIMITER $$

CREATE PROCEDURE sp_PakBoekingenAantal()
BEGIN
    SELECT COUNT(*) AS count
    FROM Boeking
    WHERE Boekingsstatus = 'Bevestigd';
END $$

DELIMITER ;

CALL sp_PakBoekingenAantal();