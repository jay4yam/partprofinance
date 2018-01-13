<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => mt_rand(0,1) ? 'admin' : 'guest',
        'avatar' => mt_rand(0,1) ? 'avatar.png' : 'avatar2.png',
    ];
});

$factory->define(App\Models\Prospect::class, function ( Faker\Generator $faker){
    return[
        'civilite' => mt_rand(0,1) ? 'Madame' : 'Monsieur',
        'nom' => $faker->lastName,
        'prenom' => $faker->firstName(),
        'dateDeNaissance' => $faker->date(),
        'nomEpoux' => $faker->lastName,
        'nationalite' => $faker->country,
        'paysNaissance' => $faker->country,
        'departementNaissance' => $faker->countryCode,
        'VilleDeNaissance' => $faker->city,
        'situationFamiliale' => mt_rand(0,1) ? 'Marié(e)' : 'Célibataire',
        'nbEnfantACharge' => mt_rand(0,4),
        'adresse' => $faker->address,
        'complementAdresse' => NULL,
        'codePostal' => $faker->postcode,
        'ville' => $faker->city,
        'numTelFixe' => NULL,
        'numTelPortable' => $faker->phoneNumber,
        'habitation' => mt_rand(0,1) ? 'Propriétaire' : 'Locataire',
        'habiteDepuis' => $faker->date(),
        'secteurActivite' => mt_rand(0,1) ? 'Secteur privé' : 'Secteur public',
        'profession' => $faker->jobTitle,
        'professionDepuis' => $faker->date(),
        'secteurActiviteConjoint' => mt_rand(0,1) ? NULL : 'Secteur public',
        'professionConjoint' => mt_rand(0,1) ? NULL : $faker->jobTitle,
        'professionDepuisConjoint' => $faker->date(),
        'revenusNetMensuel' => mt_rand(1000, 4000),
        'revenusNetMensuelConjoint' => mt_rand(0, 1) ? NULL : 2000.00,
        'loyer' => mt_rand(400,1500),
        'credits'=> json_encode(array('banque pop' => mt_rand(40, 300), 'cetelem' => mt_rand(40, 300))),
        'pensionAlimentaire' => mt_rand(0, 1) ? NULL : mt_rand(40, 300),
        'NomBanque' => mt_rand(0, 1) ? 'BNP PARISBAS' : 'BANQUE POSTALE',
        'BanqueDepuis' => $faker->date(),
        'iban' => 'FR899099988898889800998',
        'notes' => mt_rand(0, 1) ? NULL : $faker->paragraph(1),
    ];
});
