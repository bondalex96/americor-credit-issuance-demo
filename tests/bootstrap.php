<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}


passthru('php bin/console d:d:c -q --if-not-exists --env=test');
passthru('php bin/console doctrine:schema:drop -q --force --full-database --env=test');
passthru('php bin/console doctrine:migrations:migrate -q --no-interaction --env=test');
