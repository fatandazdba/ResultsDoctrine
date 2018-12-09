
<?php
/**
 * Created by PhpStorm.
 * User: bdolero
 * Date: 2018-12-03
 * Time: 16:39
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
$size_argc=$argc;
if (in_array('--json', $argv, true)){
    $size_argc=$size_argc-1;
}
for( $i=1; $i < $size_argc ; $i++){

    $userId = (int) $argv[$i];
    $userRepo =$entityManager->getRepository(User::class);
    /** @var User $userId */
    $user = $userRepo->find($userId);

    try{
        /**
         * @var User $user
         */
        $entityManager->remove($user);
        $entityManager->flush();

        if (in_array('--json', $argv, true)){
            echo "El usuario con id: $userId ha sido eliminado"  . PHP_EOL . json_encode($user, JSON_PRETTY_PRINT);
        } else {
            echo $user . ' has been deleted ' . PHP_EOL;
         }

    } catch (Exception $exception){
        echo " This user id: $userId doesn't exist. " . PHP_EOL;
    }
}

