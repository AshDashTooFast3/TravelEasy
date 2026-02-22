DROP PROCEDURE IF EXISTS sp_WijzigBericht;

DELIMITER $$

CREATE PROCEDURE sp_WijzigBericht(
    IN p_Id INT,
    IN p_PatientId INT,
    IN p_MedewerkerId INT,
    IN p_Bericht VARCHAR(255),
    IN p_VerzondenDatum VARCHAR(12) DEFAULT NULL,
    IN p_Status VARCHAR(30) DEFAULT 'In behandeling'
)
BEGIN
    UPDATE Communicatie
    
    SET PatientId = p_PatientId,
        MedewerkerId = p_MedewerkerId,
        Bericht = p_Bericht,
        VerzondenDatum = p_VerzondenDatum,
        Status = p_Status
        
    WHERE Id = p_Id;

END$$

DELIMITER ;
