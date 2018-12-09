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
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(
    __DIR__ . '/..',
    Utils::getEnvFileName(__DIR__ . '/..')
);
$dotenv->load();

$entityManager = Utils::getEntityManager();

for($i=1; $i < $argc ; $i++){

    $entityManager = Utils::getEntityManager();
    $resultRepo =$entityManager->getRepository(Result::class);
    $result = $resultRepo->find((int) $argv[$i]);

    try {
        if($result === null)
            echo "El id: $argv[$i] del result que trata de eliminar no ha sido encontrado"  . PHP_EOL;
        else {
            $entityManager->remove($result);
            $entityManager->flush();
            echo "Result id: $argv[$i] ha sido eliminado  " . $result . PHP_EOL;
        }
    } catch (Exception $exception) {
        echo 'Result no ha sido eliminado ' . $exception->getMessage() . PHP_EOL;
    }
}
