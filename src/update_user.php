<?php
/**
 * PHP version 7.3
 * src\create_result.php
 *
 * @category Utils
 * @package  MiW\Results
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

if ($argc !== 5) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <UserId> <Username> <Email> <Password>

MARCA_FIN;
    exit(0);
}

$userId = (int)$argv[1];
$newUsername = (string)$argv[2];
$newEmail = (string)$argv[3];
$newPassword = (string)$argv[4];

/** @var User $user */
$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $userId]);
if (null === $user) {
    echo "Usuario $userId no encontrado" . PHP_EOL;
    exit(0);
}

$user->setUsername($newUsername);
$user->setEmail($newEmail);
$user->setPassword($newPassword);
try {
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'Updated User with ID #' . $user->getId() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}
