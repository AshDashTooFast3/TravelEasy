USE smilepro;

DROP PROCEDURE IF EXISTS sp_OmzetBerekenen;

DELIMITER $$

CREATE PROCEDURE sp_OmzetBerekenen()

BEGIN

    SELECT SUM(Bedrag) AS TotaleOmzet
    FROM Factuur
    WHERE Status = 'Betaald';

END$$

DELIMITER ;