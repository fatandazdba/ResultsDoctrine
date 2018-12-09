<?php
/**
 * PHP version 7.2
 * src\create_result.php
 *
 * @category Utils
 * @package  MiW\Results
 * @author   Javier Gil <franciscojavier.gil@upm.es>
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

if ($argc === 0) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN
    
    Modify Result usage: $fich <userid> <result> 

MARCA_FIN;
    exit(0);
}
if ($argc < 4 || $argc > 5) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <Resulst_id> <User_id> <Result>

MARCA_FIN;
    exit(0);
}
$resultId = (int) $argv[1];
$user_id = (int) $argv[2];
$result_va = (int) $argv[3];

$resultRepo = $entityManager->getRepository(Result::class);
$result = $resultRepo->find($resultId);
echo 'Result: '. $result . PHP_EOL;
    if ($result == null){
        echo "No se pudo encontrar el result con id: ". $resultId . PHP_EOL;
    }
    $userRepo = $entityManager->getRepository(User::class);
    $user = new User();
    $user = $userRepo->find($user_id);
    if ($user == null){
        echo "El usuario con id: $user_id no ha sido encontrado " . PHP_EOL;
        exit(0);
    }else{
        $result->setUser($user);
        $result->setResult($result_va);
        $currentTime = date('H:i:s');
        $result->setTime((new \DateTime()));
        try{
            $entityManager->merge($result);
            $entityManager->flush();
            if (in_array('--json', $argv, true)){
                echo json_encode($result, JSON_PRETTY_PRINT);
            } else{
                echo 'El result id: ' .$result->getId(). ' ha sido editado' . PHP_EOL;
            }

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
        exit(0);
    }



