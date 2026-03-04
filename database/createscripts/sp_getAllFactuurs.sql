USE TravelEasy;

DROP PROCEDURE IF EXISTS sp_getAllFactuurs;

DELIMITER $$

CREATE PROCEDURE sp_getAllFactuurs()
BEGIN
    SELECT 
        f.Id
        ,b.Boekingsnummer
        ,CONCAT_WS(' ', pe.Voornaam, NULLIF(pe.Tussenvoegsel, ''), pe.Achternaam) AS PassagierNaam
        ,f.Factuurnummer
        ,f.Factuurdatum
        ,f.Factuurtijd
        ,f.TotaalBedrag
        ,f.Betaalstatus
        ,f.Betaalmethode
        ,f.IsActief
        ,f.Opmerking
        ,f.Datumaangemaakt
        ,f.Datumgewijzigd
    FROM Factuur f
    INNER JOIN Boeking b ON f.BoekingId = b.Id
    INNER JOIN Passagier p ON f.PassagierId = p.Id
    INNER JOIN Persoon pe ON p.PersoonId = pe.Id
    WHERE f.IsActief = 1
    ORDER BY f.Factuurdatum DESC;
END$$

DELIMITER ;

CALL sp_getAllFactuurs();
