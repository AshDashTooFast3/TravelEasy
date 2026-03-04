USE TravelEasy;
DROP PROCEDURE IF EXISTS sp_MeestVoorkomendReis;

DELIMITER $$

CREATE PROCEDURE sp_MeestVoorkomendReis()
BEGIN
    SELECT 
        ver.Luchthaven AS VertrekLuchthaven, 
        ver.Land AS VertrekLand,
        bes.Luchthaven AS BestemmingLuchthaven, 
        bes.Land AS BestemmingLand,
        COUNT(boe.Id) AS AantalBoekingen
    FROM Boeking boe
    JOIN Vlucht v ON boe.VluchtId = v.Id
    JOIN Bestemming bes ON v.BestemmingId = bes.Id
    JOIN Vertrek ver ON v.VertrekId = ver.Id
    WHERE boe.Boekingsstatus != 'Geannuleerd'
    AND v.Vluchtstatus != 'Geannuleerd'
    GROUP BY VluchtId
    ORDER BY AantalBoekingen DESC
    LIMIT 5;
END $$

DELIMITER ;

CALL sp_MeestVoorkomendReis();

