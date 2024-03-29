<?php
/**
 * PHP version 7.2
 * src\create_result.php
 *
 * @category Utils
 * @package  MiW\Results
 * @author   Freddy Tandazo <freddy.tandazo.yanez@alumnos.upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(
    __DIR__ . '/..',
    Utils::getEnvFileName(__DIR__ . '/..')
);
$dotenv->load();

$entityManager = Utils::getEntityManager();

if ($argc < 4 || $argc > 5) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <username> <email> <password>

MARCA_FIN;
    exit(0);
}

$user = new User();
$user->setUsername((string) $argv[1]);
$user->setEmail((string) $argv[2]);
$user->setPassword((string) $argv[3]);
$user->setEnabled(false);
$user->setIsAdmin(false);

$entityManager = Utils::getEntityManager();

try {
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'Created User with ID #' . $user->getId() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
