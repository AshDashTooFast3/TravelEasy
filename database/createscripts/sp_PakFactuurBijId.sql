USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_PakFactuurBijId;

DELIMITER $$

CREATE PROCEDURE sp_PakFactuurBijId(
    IN p_FactuurId INT UNSIGNED
)
BEGIN
    SELECT 
        Id,
        PassagierId,
        Factuurdatum,
        TotaalBedrag AS Bedrag,
        Betaalmethode,
        Betaalstatus
    FROM Factuur
    WHERE Id = p_FactuurId;
END$$

DELIMITER ;

CALL sp_PakFactuurBijId(1);