USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_GetBoekingenCount;

DELIMITER $$

CREATE PROCEDURE sp_GetBoekingenCount()
BEGIN
    SELECT COUNT(*) AS BoekingenCount 
    FROM Boeking;
END $$

DELIMITER ;

CALL sp_GetBoekingenCount();