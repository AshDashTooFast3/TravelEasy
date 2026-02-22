DROP PROCEDURE IF EXISTS sp_getVoorkomendeBehandelingen;
DELIMITER $$

CREATE PROCEDURE sp_getVoorkomendeBehandelingen()
BEGIN
    SELECT 
        b.Behandelingtype AS Behandelingtype,
        COUNT(f.BehandelingId) AS AantalUitgevoerd
    FROM Behandeling b
    INNER JOIN Factuur f ON b.Id = f.BehandelingId
    GROUP BY b.Behandelingtype
    ORDER BY AantalUitgevoerd DESC;
END $$

DELIMITER ;


CALL sp_getVoorkomendeBehandelingen();