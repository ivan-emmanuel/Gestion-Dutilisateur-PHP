<?php


$config = [
    'APP_NAME' => "Espace membre PHP",
    'APP_ENV' => getenv('APP_ENV') ?? "development" ,
    'DEFAULT_SMTP' => "MAILDEV",
    'DB_MYSQL' => [
        'HOST' => "localhost",
        'LOGIN' => 'root',
        'PASSWORD' => '',
        'DBNAME' => 'users',
    ],
    'MAIL_CONFIG' => [
        'MAIL_HOST' => 'smtp.mailtrap.io',
        'MAIL_PORT' => '2525',
        'MAIL_USERNAME' => null,
        'MAIL_PASSWORD' => null,
        'ENCRYPT' => "tls",
    ],
    'ENABLE_MAILS' => false
];

//  Verification si l'application est en mode production
//  Vérification de l'hôte en mode CGI
//  Vérification de l'hôte en mode CLI
//  Chargement de la config en production
if ( $config['APP_ENV'] =='production' && is_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . "production.php")) {
    $production_config = require dirname(__FILE__) . DIRECTORY_SEPARATOR . "production.php";
    $config = array_merge($config, $production_config);
}

return $config;