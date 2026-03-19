USE TravelEasy;

SELECT * FROM Factuur;

DROP PROCEDURE IF EXISTS sp_WijzigFactuur;

DELIMITER $$
CREATE PROCEDURE sp_WijzigFactuur(
    IN p_FactuurId INT,
    IN p_BoekingId INT,
    IN p_PassagierId INT,
    IN p_Factuurnummer VARCHAR(50),
    IN p_Factuurdatum DATE,
    IN p_Factuurtijd TIME,
    IN p_TotaalBedrag DECIMAL(10, 2),
    IN p_Betaalstatus VARCHAR(50),
    IN p_Betaalmethode VARCHAR(50),
    IN p_Isactief BOOLEAN,
    IN p_Opmerking VARCHAR(255)
)
BEGIN
    UPDATE Factuur
    SET 
        BoekingId = p_BoekingId,
        PassagierId = p_PassagierId,
        Factuurnummer = p_Factuurnummer,
        Factuurdatum = p_Factuurdatum,
        Factuurtijd = p_Factuurtijd,
        TotaalBedrag = p_TotaalBedrag,
        Betaalstatus = p_Betaalstatus,
        Betaalmethode = p_Betaalmethode,
        Isactief = p_Isactief,
        Opmerking = p_Opmerking,
        Datumgewijzigd = NOW()
    WHERE Id = p_FactuurId;
END$$

DELIMITER ;

CALL sp_WijzigFactuur(1, 1, 1, 'FACT-001', '2023-01-01', '10:00:00', 100.00, 'Betaald', 'Creditcard', 1, 'Opmerking');