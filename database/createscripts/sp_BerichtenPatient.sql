USE smilepro;

DROP PROCEDURE IF EXISTS sp_GetBerichtenVoorPatient;

DELIMITER $$

        CREATE PROCEDURE sp_GetBerichtenVoorPatient(
        	IN patientId INT
        )
        BEGIN
            SELECT 
                COM.Id,
                COM.PatientId,
                COM.MedewerkerId,
                COM.Bericht,

                -- Patient info
                PAT.Nummer AS PatientNummer,
                PER_PAT.Voornaam AS PatientVoornaam,
                PER_PAT.Tussenvoegsel AS PatientTussenvoegsel,
                PER_PAT.Achternaam AS PatientAchternaam,

                -- Medewerker info
                MED.Nummer AS MedewerkerNummer,
                PER_MED.Voornaam AS MedewerkerVoornaam,
                PER_MED.Tussenvoegsel AS MedewerkerTussenvoegsel,
                PER_MED.Achternaam AS MedewerkerAchternaam

            FROM Communicatie COM
            INNER JOIN Medewerker MED ON COM.MedewerkerId = MED.Id
            INNER JOIN Persoon PER_MED ON MED.PersoonId = PER_MED.Id
            INNER JOIN Patient PAT ON COM.PatientId = PAT.Id
            INNER JOIN Persoon PER_PAT ON PAT.PersoonId = PER_PAT.Id
            WHERE PAT.Id = GebruikerId
            AND Status = 'Verzonden';
        END$$

DELIMITER ;

CALL sp_GetBerichtenVoorPatient();