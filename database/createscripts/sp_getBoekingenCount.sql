USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_getBoekingenCount;

DELIMITER $$

CREATE PROCEDURE sp_getBoekingenCount()
BEGIN
    SELECT COUNT(*) AS count
    FROM Boeking
    WHERE Boekingsstatus = 'Bevestigd';
END $$

DELIMITER ;

CALL sp_getBoekingenCount();