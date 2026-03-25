USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_AnnuleerFactuur;

DELIMITER $$

CREATE PROCEDURE sp_AnnuleerFactuur(
    IN p_FactuurId INT
)

BEGIN
    DELETE 
    FROM Factuur
    WHERE id = p_FactuurId;
END$$

DELIMITER ;

CALL sp_AnnuleerFactuur(1); -- Vervang 1 door het gewenste factuur Id om te annuleren