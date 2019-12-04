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
use MiW\Results\Utils;

require __DIR__ . '/../../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../../');

$entityManager = Utils::getEntityManager();

if ($argc !== 2) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <ResultId>

MARCA_FIN;
    exit(0);
}

$resultId = (int)$argv[1];

/** @var Result $result */
$result = $entityManager
    ->getRepository(Result::class)
    ->findOneBy(['id' => $resultId]);
if (null === $result) {
    echo "Resultado $resultId no encontrado" . PHP_EOL;
    exit(0);
}

try {
    $entityManager->remove($result);
    $entityManager->flush();
    echo 'Deleted Result with ID #' . $resultId . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}
