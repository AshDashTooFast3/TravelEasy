USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_PakAllePassagiers;

DELIMITER $$

CREATE PROCEDURE sp_PakAllePassagiers()

BEGIN
    SELECT 
        p.Id
        ,p.PersoonId
        ,per.Voornaam
        ,per.Tussenvoegsel
        ,per.Achternaam
        ,p.Nummer
        ,p.PassagierType
        ,p.IsActief
        ,p.Opmerking
        ,p.Datumaangemaakt
        ,p.Datumgewijzigd
    FROM Passagier p
    INNER JOIN Persoon per ON p.PersoonId = per.Id
    ORDER BY p.Nummer ASC;
END$$

DELIMITER ;

CALL sp_PakAllePassagiers();