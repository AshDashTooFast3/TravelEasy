USE smilepro;

DROP PROCEDURE IF EXISTS sp_GetAllFactuur;

DELIMITER $$

CREATE PROCEDURE sp_GetAllFactuur()
BEGIN
    SELECT 
        persoon.Voornaam AS PatientVoornaam, 
        persoon.Tussenvoegsel AS PatientTussenvoegsel,
        persoon.Achternaam AS PatientAchternaam, 
        b.Behandelingtype AS BehandelingType,
        f.Id,
        f.PatientId,
        f.BehandelingId,
        f.Nummer, 
        f.Datum, 
        f.Bedrag, 
        f.Status,
        f.Isactief
    FROM Factuur f
    INNER JOIN Patient p ON f.PatientId = p.Id
    INNER JOIN Persoon persoon ON p.PersoonId = persoon.Id
    INNER JOIN Behandeling b ON f.BehandelingId = b.Id;
END $$

DELIMITER ;

CALL sp_GetAllFactuur();