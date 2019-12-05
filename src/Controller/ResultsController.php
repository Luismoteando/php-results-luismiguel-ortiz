<?php

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

function homeController(): void
{
    global $routes;

    $resultListingRoute = $routes->get('route_results_list')->getPath();
    $userListingRoute = $routes->get('route_users_list')->getPath();

    echo <<< HTML_TAG
        <h3>
            Menú principal
        </h3>
        <ul>
            <li>
                <a href="$resultListingRoute">Listado resultados</a>
            </li>
            <li>
                <a href="$userListingRoute">Listado usuarios</a>
            </li>
        </ul>
    HTML_TAG;
}

function resultsListingController(): void
{
    global $routes;

    $entityManager = Utils::getEntityManager();

    $results = $entityManager
        ->getRepository(Result::class)
        ->findAll();
    $newResultRoute = $routes->get('route_new_result')->getPath();
    $homeRoute = $routes->get('route_home')->getPath();
    $deleteResultRoute = $routes->get('route_delete_result')->getPath();
    $deleteResultUrl = substr($deleteResultRoute, 0, strrpos($deleteResultRoute, '/'));
    $updateResultRoute = $routes->get('route_update_result')->getPath();
    $updateResultUrl = substr($updateResultRoute, 0, strrpos($updateResultRoute, '/'));

    echo <<< HTML_TAG
        <h3>
            Listado resultados
        </h3>    
    HTML_TAG;
    foreach ($results as $result) {
        $id = $result->getId();
        echo <<< HTML_TAG
            <li>$result | <a href='$updateResultUrl/$id'>Editar</a> | <a href='$deleteResultUrl/$id'>Eliminar</a></li>
        HTML_TAG;
    }
    echo <<< HTML_TAG
        <a href="$homeRoute">< Volver</a> | <a href="$newResultRoute">Nuevo resultado ></a>
    HTML_TAG;
}

function newResultController()
{
    global $routes;

    echo <<< HTML_TAG
        <h3>Nuevo resultado</h3>
    HTML_TAG;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $newResultRoute = $routes->get('route_new_result')->getPath();
        echo <<< HTML_TAG
            <form method="POST" action="$newResultRoute">
                Resultado: <input type="number" name="result"><br>
                #Id Usuario: <input type="number" name="user"><br>
                Fecha/Hora: <input type="datetime-local" name="datetime" value=""><br>
                <input type="submit" value="Enviar"> 
            </form>
        HTML_TAG;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $entityManager = Utils::getEntityManager();

        $result = $_POST['result'];
        $user = (empty($_POST['user'])) ? null : $entityManager->find(User::Class, $_POST['user']);
        $datetime = (empty($_POST['datetime'])) ? null : new DateTime($_POST['datetime']);
        $newResult = new Result($result, $user, $datetime);

        $entityManager->persist($newResult);
        $entityManager->flush();
        var_dump($newResult);
    }

    $resultListingRoute = $routes->get('route_results_list')->getPath();
    echo "<a href='$resultListingRoute'>< Volver</a>";
}

function deleteResultController(int $id)
{
    global $routes;

    $entityManager = Utils::getEntityManager();
    $result = $entityManager
        ->getRepository(Result::class)
        ->findOneBy(['id' => $id]);
    if ($result) {
        $entityManager->remove($result);
        $entityManager->flush();
        echo '<h3>Result deleted!</h3>';
    } else {
        echo '<h3>Result doesn\'t exist!</h3>';
    }
    $resultListingRoute = $routes->get('route_results_list')->getPath();
    echo <<< HTML_TAG
            <a href=$resultListingRoute>< Volver</a>
    HTML_TAG;
}

function updateResultController(int $id)
{
    global $routes;

    echo <<< HTML_TAG
        <h3>Editar resultado</h3>
    HTML_TAG;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $updateResultRoute = $routes->get('route_update_result')->getPath();
        $updateResultUrl = substr($updateResultRoute, 0, strrpos($updateResultRoute, '/'));
        echo <<< HTML_TAG
            <form method="POST" action="$updateResultUrl/$id">
                Resultado: <input type="number" name="result"><br>
                #Id Usuario: <input type="number" name="user"><br>
                Fecha/Hora: <input type="datetime-local" name="datetime" value=""><br>
                <input type="submit" value="Enviar"> 
            </form>
        HTML_TAG;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $entityManager = Utils::getEntityManager();

        $result = $_POST['result'];
        $user = (empty($_POST['user'])) ? null : $entityManager->find(User::Class, $_POST['user']);
        $datetime = (empty($_POST['datetime'])) ? null : new DateTime($_POST['datetime']);

        $updatedResult = $entityManager
            ->getRepository(Result::class)
            ->find($id);
        $updatedResult->setResult($result);
        $updatedResult->setUser($user);
        $updatedResult->setTime($datetime);

        $entityManager->persist($updatedResult);
        $entityManager->flush();
        var_dump($updatedResult);
    }

    $resultListingRoute = $routes->get('route_results_list')->getPath();
    echo "<a href='$resultListingRoute'>< Volver</a>";
}

function usersListingController(): void
{
    global $routes;

    $entityManager = Utils::getEntityManager();

    $users = $entityManager
        ->getRepository(User::class)
        ->findAll();
    $newUserRoute = $routes->get('route_new_user')->getPath();
    $homeRoute = $routes->get('route_home')->getPath();
    $deleteUserRoute = $routes->get('route_delete_user')->getPath();
    $deleteUserUrl = substr($deleteUserRoute, 0, strrpos($deleteUserRoute, '/'));
    $updateUserRoute = $routes->get('route_update_user')->getPath();
    $updateUserUrl = substr($updateUserRoute, 0, strrpos($updateUserRoute, '/'));

    echo <<< HTML_TAG
        <h3>
            Listado usuarios
        </h3>    
    HTML_TAG;
    foreach ($users as $user) {
        $id = $user->getId();
        echo <<< HTML_TAG
            <li>$user | <a href='$updateUserUrl/$id'>Editar</a> | <a href='$deleteUserUrl/$id'>Eliminar</a></li>
        HTML_TAG;
    }
    echo <<< HTML_TAG
        <a href="$homeRoute">< Volver</a> | <a href="$newUserRoute">Nuevo usuario ></a>
    HTML_TAG;
}

function newUserController()
{
    global $routes;

    echo <<< HTML_TAG
        <h3>Nuevo usuario</h3>
    HTML_TAG;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $newUserRoute = $routes->get('route_new_user')->getPath();
        echo <<< HTML_TAG
        
            <form method="POST" action="$newUserRoute">
                Nombre de usuario: <input type="string" name="username"><br>
                Email: <input type="email" name="email"><br>
                Contraseña: <input type="password" name="password" value=""><br>
                <input type="submit" value="Enviar"> 
            </form>
        HTML_TAG;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $entityManager = Utils::getEntityManager();

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $newUser = new User($username, $email, $password);

        $entityManager->persist($newUser);
        $entityManager->flush();
        var_dump($newUser);
    }

    $userListingRoute = $routes->get('route_users_list')->getPath();
    echo "<a href='$userListingRoute'>< Volver</a>";
}

function deleteUserController(int $id)
{
    global $routes;

    $entityManager = Utils::getEntityManager();
    $user = $entityManager
        ->getRepository(User::class)
        ->findOneBy(['id' => $id]);
    if ($user) {
        $entityManager->remove($user);
        $entityManager->flush();
        echo '<h3>User deleted!</h3>';
    } else {
        echo '<h3>User doesn\'t exist!</h3>';
    }
    $userListingRoute = $routes->get('route_users_list')->getPath();
    echo <<< HTML_TAG
            <a href=$userListingRoute>< Volver</a>
    HTML_TAG;
}

function updateUserController(int $id)
{
    global $routes;

    echo <<< HTML_TAG
        <h3>Editar usuario</h3>
    HTML_TAG;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $updateUserRoute = $routes->get('route_update_user')->getPath();
        $updateUserUrl = substr($updateUserRoute, 0, strrpos($updateUserRoute, '/'));
        echo <<< HTML_TAG
            <form method="POST" action="$updateUserUrl/$id">
                Nombre de usuario: <input type="string" name="username"><br>
                Email: <input type="email" name="email"><br>
                Contraseña: <input type="password" name="password" value=""><br>
                <input type="submit" value="Enviar"> 
            </form>
        HTML_TAG;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $entityManager = Utils::getEntityManager();

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $updatedUser = $entityManager
            ->getRepository(User::class)
            ->find($id);
        $updatedUser->setUsername($username);
        $updatedUser->setEmail($email);
        $updatedUser->setPassword($password);

        $entityManager->persist($updatedUser);
        $entityManager->flush();
        var_dump($updatedUser);
    }

    $userListingRoute = $routes->get('route_users_list')->getPath();
    echo "<a href='$userListingRoute'>< Volver</a>";
}



