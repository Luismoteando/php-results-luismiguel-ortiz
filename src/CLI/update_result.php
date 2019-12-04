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

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../../');

$entityManager = Utils::getEntityManager();

if ($argc < 3 || $argc > 4) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <ResultId> <Result> <UserId> [<Timestamp>]

MARCA_FIN;
    exit(0);
}

$resultId = (int)$argv[1];
$newResult = (int)$argv[2];
$newUserId = (int)$argv[3];
$newTimestamp = $argv[4] ?? new DateTime('now');

/** @var Result $result */
$result = $entityManager
    ->getRepository(Result::class)
    ->findOneBy(['id' => $resultId]);
if (null === $result) {
    echo "Resultado $resultId no encontrado" . PHP_EOL;
    exit(0);
}

/** @var User $user */
$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $newUserId]);
if (null === $user) {
    echo "Usuario $newUserId no encontrado" . PHP_EOL;
    exit(0);
}

$result->setResult($newResult);
$result->setUser($user);
$result->setTime($newTimestamp);
try {
    $entityManager->persist($result);
    $entityManager->flush();
    echo 'Updated Result with ID ' . $result->getId()
        . ' USER ' . $user->getUsername() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}
