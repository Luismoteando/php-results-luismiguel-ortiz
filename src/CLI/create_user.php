<?php
/**
 * PHP version 7.3
 * src\create_user_admin.php
 *
 * @category Utils
 * @package  MiW\Results
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../../');

$entityManager = Utils::getEntityManager();

if ($argc !== 4) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <Username> <Email> <Password>

MARCA_FIN;
    exit(0);
}

$newUsername = (string)$argv[1];
$newEmail = (string)$argv[2];
$newPassword = (string)$argv[3];

$user = new User();
$user->setUsername($newUsername);
$user->setEmail($newEmail);
$user->setPassword($newPassword);
$user->setEnabled(true);
$user->setIsAdmin(false);

try {
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'Created User with ID #' . $user->getId() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
