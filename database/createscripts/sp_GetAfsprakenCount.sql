USE smilepro;

DROP PROCEDURE IF EXISTS sp_GetAfsprakenCount;

DELIMITER $$

CREATE PROCEDURE sp_GetAfsprakenCount()

BEGIN
    SELECT COUNT(*) AS AfsprakenCount
    FROM Afspraken;
END$$

DELIMITER ;