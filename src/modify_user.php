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

if ($argc === 0) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN
    
    Modify User usage: $fich <userid> <result> 

MARCA_FIN;
    exit(0);
}
if ($argc < 5 || $argc > 6) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <id_user> <username> <email> <password> <json>

MARCA_FIN;
    exit(0);
}

$user = new User();

$user_id =  (int)    $argv[1];
$username = (string) $argv[2];
$email =    (string) $argv[3];
$password = (string) $argv[4];



$userRepo = $entityManager->getRepository(User::class);
$user = $userRepo->find($user_id);

if ($user == null){
    echo "El usuario con id: $user_id no ha sido encontrado " . PHP_EOL;
    exit(0);
}else{
    $user->setUsername($username);
    $user->setEmail($email);
    $user->setEnabled(false);
    $user->setIsAdmin(false);
    $user->setPassword($password);

    try{
        $entityManager->merge($user);
        $entityManager->flush();
        if (in_array('--json', $argv, true)){
            echo json_encode($user, JSON_PRETTY_PRINT);
        } else{
            echo 'El user ha sido editado ->' . $user . PHP_EOL;
        }

    } catch (Exception $exception) {
        echo "Un error ha ocurrido verifique que el username y el mail esten siendo ocupados por otro usuario " . $exception->getMessage() . PHP_EOL;;
    }
    exit(0);
}
