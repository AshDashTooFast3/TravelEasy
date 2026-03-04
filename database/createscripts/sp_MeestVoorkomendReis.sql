USE TravelEasy;
DROP PROCEDURE IF EXISTS sp_MeestVoorkomendReis;

DELIMITER $$

CREATE PROCEDURE sp_MeestVoorkomendReis()
BEGIN
    SELECT v.Id, v.BestemmingId, COUNT(bo.Id) AS AantalBoekingen
    FROM Vlucht v
    JOIN Accommodatie a ON v.Id = a.VluchtId
    JOIN Boeking bo ON a.Id = bo.AccommodatieId
    WHERE bo.Boekingsstatus != 'Geannuleerd'
    AND v.Vluchtstatus != 'Geannuleerd'
    GROUP BY v.Id, v.BestemmingId
    ORDER BY AantalBoekingen DESC
    LIMIT 5;
END $$

DELIMITER ;

CALL sp_MeestVoorkomendReis();

