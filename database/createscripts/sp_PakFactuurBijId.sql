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
        Betaalmethode
    FROM Factuur
    WHERE Id = p_FactuurId
    AND IsActief = 1;
END$$

DELIMITER ;

CALL sp_PakFactuurBijId(1);