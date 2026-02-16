<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Gebruiker', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Gebruikersnaam', 50);
            $table->string('Wachtwoord', 100);
            $table->string('RolNaam', 50);
            $table->string('Email', 100)->unique();
            $table->dateTime('Ingelogd');
            $table->dateTime('Uitgelogd');
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
        });

        Schema::create('Persoon', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('GebruikerId');
            $table->string('Voornaam', 50);
            $table->string('Tussenvoegsel', 20)->nullable();
            $table->string('Achternaam', 50);
            $table->date('Geboortedatum');
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
            $table->foreign('GebruikerId')->references('Id')->on('Gebruiker');
        });

        Schema::create('Passagier', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PersoonId');
            $table->integer('Nummer');
            $table->string('PassagierType', 100);
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt')->useCurrent();
            $table->dateTime('Datumgewijzigd')->useCurrent();
            $table->foreign('PersoonId')->references('Id')->on('Persoon');
        });

        Schema::create('Medewerker', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PersoonId');
            $table->string('Nummer', 20);
            $table->string('Medewerkertype', 255);
            $table->string('Specialisatie', 100)->nullable();
            $table->string('Beschikbaarheid', 20)->nullable();
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
            $table->foreign('PersoonId')->references('Id')->on('Persoon');
        });

        Schema::create('Vertrek', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Land', 50);
            $table->string('Luchthaven', 20);
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
        });

        Schema::create('Bestemming', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Land', 50);
            $table->string('Luchthaven', 20);
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
        });

        Schema::create('Vlucht', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('VertrekId');
            $table->unsignedInteger('BestemmingId');
            $table->string('Vluchtnummer', 5);
            $table->date('Vertrekdatum');
            $table->time('Vertrektijd');
            $table->date('Aankomstdatum');
            $table->time('Aankomsttijd');
            $table->string('Vluchtstatus', 20);
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
            $table->foreign('VertrekId')->references('Id')->on('Vertrek');
            $table->foreign('BestemmingId')->references('Id')->on('Bestemming');
        });

        Schema::create('Accommodatie', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('VluchtId');
            $table->string('Naam', 255);
            $table->string('Type', 100);
            $table->string('Straat', 255);
            $table->string('Huisnummer', 10);
            $table->string('Toevoeging', 5)->nullable();
            $table->string('Postcode', 20);
            $table->string('Stad', 100);
            $table->string('Land', 100);
            $table->date('CheckInDatum');
            $table->date('CheckOutDatum');
            $table->tinyInteger('AantalKamers')->default(1);
            $table->smallInteger('AantalPersonen');
            $table->decimal('PrijsPerNacht', 10, 2);
            $table->decimal('TotaalPrijs', 10, 2);
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
            $table->foreign('VluchtId')->references('Id')->on('Vlucht');
        });

        Schema::create('Ticket', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PassagierId');
            $table->unsignedInteger('VluchtId');
            $table->string('Stoelnummer', 4);
            $table->date('Aankoopdatum');
            $table->time('Aankooptijd');
            $table->decimal('Prijs', 6, 2);
            $table->tinyInteger('Aantal');
            $table->tinyInteger('Btw')->default(21);
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('NOW(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('NOW(6)'));
            $table->foreign('PassagierId')->references('Id')->on('Passagier');
            $table->foreign('VluchtId')->references('Id')->on('Vlucht');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('Email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Ticket');
        Schema::dropIfExists('Accommodatie');
        Schema::dropIfExists('Vlucht');
        Schema::dropIfExists('Bestemming');
        Schema::dropIfExists('Vertrek');
        Schema::dropIfExists('Medewerker');
        Schema::dropIfExists('Passagier');
        Schema::dropIfExists('Persoon');
        Schema::dropIfExists('Gebruiker');
    }
};
