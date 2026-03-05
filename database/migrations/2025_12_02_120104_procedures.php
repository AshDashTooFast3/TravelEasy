<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_getBoekingenCount');

        DB::statement("
            CREATE PROCEDURE sp_getBoekingenCount()
            BEGIN
                SELECT COUNT(*) AS count
                FROM Boeking
                WHERE Boekingsstatus = 'Bevestigd';
            END
        ");

        DB::statement('DROP PROCEDURE IF EXISTS sp_getAllFactuurs');

        DB::statement("
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
            END
        ");

        DB::statement('DROP PROCEDURE IF EXISTS sp_MeestVoorkomendReis');

        DB::statement("
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
            END
        ");
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
