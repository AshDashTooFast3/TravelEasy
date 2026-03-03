DROP PROCEDURE IF EXISTS sp_MeestVoorkomendReis;

DELIMITER $$

CREATE PROCEDURE sp_MeestVoorkomendReis()
BEGIN
    SELECT v.Id, b.BestemmingId, COUNT(bo.Id) AS AantalBoekingen
    FROM Vlucht v
    JOIN Accommodatie a ON v.Id = a.VluchtId
    JOIN Boeking bo ON a.Id = bo.AccommodatieId
    WHERE bo.Boekingsstatus = 'Bevestigd'
    GROUP BY v.Id, b.BestemmingId
    ORDER BY AantalBoekingen DESC
    LIMIT 5;
END $$

CALL sp_MeestVoorkomendReis();