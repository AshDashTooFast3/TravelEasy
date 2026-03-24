USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_WijzigFactuur;

DELIMITER $$
CREATE PROCEDURE sp_WijzigFactuur(
    IN p_FactuurId INT,
    IN p_PassagierId INT,
    IN p_Factuurdatum DATE,
    IN p_TotaalBedrag DECIMAL(10, 2),
    IN p_Betaalmethode VARCHAR(50)
)
BEGIN
    UPDATE Factuur
    SET 
        PassagierId = p_PassagierId,
        Factuurdatum = p_Factuurdatum,
        TotaalBedrag = p_TotaalBedrag,
        Betaalmethode = p_Betaalmethode,
        Datumgewijzigd = NOW()
    WHERE Id = p_FactuurId;
END$$

DELIMITER ;
