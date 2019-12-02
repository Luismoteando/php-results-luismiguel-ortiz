<?php

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

function homeController(): void
{

}

function usersListingController(): void
{
    $entityManager = Utils::getEntityManager();

    $usersRepository = $entityManager->getRepository(User::class);
    $users = $usersRepository->findAll();
    echo var_dump($users);
}

function resultsListingController(): void
{
    $entityManager = Utils::getEntityManager();

    $resultsRepository = $entityManager->getRepository(Result::class);
    $results = $resultsRepository->findAll();
    echo var_dump($results);
}