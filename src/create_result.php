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

use MiW\Results\Entity\Result;
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

if ($argc < 3 || $argc > 4) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <Result> <UserId> [<Timestamp>]

MARCA_FIN;
    exit(0);
}

$newResult    = (int) $argv[1];
$userId       = (int) $argv[2];
try {
    $newTimestamp = $argv[3] ?? new DateTime('now');
} catch (Exception $e) {
    echo $exception->getMessage();
}

/** @var User $user */
$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $userId]);
if (null === $user) {
    echo "Usuario $userId no encontrado" . PHP_EOL;
    exit(0);
}

$result = new Result($newResult, $user, $newTimestamp);
try {
    $entityManager->persist($result);
    $entityManager->flush();
    echo 'Created Result with ID ' . $result->getId()
        . ' USER ' . $user->getUsername() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}
