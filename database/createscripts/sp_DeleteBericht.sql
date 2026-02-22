USE smilepro;

DROP PROCEDURE IF EXISTS sp_DeleteCommunicatie;

DELIMITER $$

CREATE PROCEDURE sp_DeleteCommunicatie(
    IN p_Id int
)
BEGIN

    DELETE FROM Communicatie 
    WHERE Id = p_Id;

END$$

DELIMITER ;

