<?php

/*
|--------------------------------------------------------------------------
| Class -> Subjects map
|--------------------------------------------------------------------------
|
| Used by the classes:seed-subjects command and the MyClass "created"
| observer (see App\Observers\MyClassObserver) to make sure every class
| listed here always has its full subject list.
|
| Subject lists were extracted from the school's timetable document.
| Only classes present here get auto-seeded with subjects; a class
| created with a name that isn't a key in this array is left alone,
| since we don't have a known curriculum to apply to it.
|
*/

return [

    'Sixième' => [
        'Anglais',
        'Arabe',
        'Art plastique',
        'Atelier',
        'EPS',
        'Espagnol',
        'Français',
        'Histoire géo',
        'Islamique',
        'Maths',
        'Physique',
        'SVT',
    ],

    'Cinquième' => [
        'Anglais',
        'Arabe',
        'Art plastique',
        'Atelier',
        'EPS',
        'Espagnol',
        'Français',
        'Histoire géo',
        'Islamique',
        'Maths',
        'Physique',
        'SVT',
    ],

    'Quatrième' => [
        'Anglais',
        'Arabe',
        'Art plastique',
        'Atelier',
        'EPS',
        'Espagnol',
        'Français',
        'Histoire géo',
        'Islamique',
        'Maths',
        'Physique',
        'SVT',
    ],

    'Troisième' => [
        'Anglais',
        'Arabe',
        'Art plastique',
        'Atelier',
        'EPS',
        'Espagnol',
        'Français',
        'Histoire géo',
        'Maths',
        'Physique',
        'SVT',
    ],

    'Seconde' => [
        'Anglais',
        'Arabe',
        'Art plastique',
        'Atelier',
        'EPS',
        'Espagnol',
        'Français',
        'Histoire géo',
        'Islamique',
        'Maths',
        'Physique',
        'SES',
        'SVT',
    ],

    'Première' => [
        'Anglais',
        'Arabe',
        'EPS',
        'ES',
        'Français',
        'Histoire géo',
        'Maths',
        'Physique',
        'SES',
        'SVT',
    ],

    'Terminale' => [
        'Anglais',
        'Arabe',
        'EPS',
        'ES',
        'Français',
        'Histoire géo',
        'Maths',
        'Philo',
        'Physique',
        'SES',
        'SVT',
    ],

    'Terminale melissa' => [
        'Anglais',
        'Arabe',
        'EPS',
        'ES',
        'Français',
        'Géopolitique',
        'Histoire géo',
        'Maths',
        'Philo',
        'Physique',
        'SES',
        'SVT',
        'Spé Anglais',
    ],

    'Terminale STMG' => [
        'Anglais',
        'Arabe',
        'Droit et économie',
        'EPS',
        'Histoire géo',
        'Maths',
        'Management (Séance de gestion et numérique)',
        'Mercatique',
        'Philo',
    ],

];
