<?php

// namespace App\Controller;
// require __DIR__.'/../config/Database.php';
// use App\config\Database;
// use App\Model\User;
// use App\Service\View;
// use PDO;

// $pdo= Database::connect();
// class AuthController
// {
//     private array $users = [];
//     function showLogin()
//     {
//         (new View())->render('login.html.twig', [
//             'title' => 'Login',
//             'user' => 'kara'
//         ]);
//     }
//     function getUsers()
//     {
//         global $pdo;
//         $sql = 'SELECT * FROM users';

//         $stmt = $pdo->prepare($sql);
//         $stmt->execute();
//         $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         return $users;
//     }

//     function login($email, $password)
//     {

//         global $pdo;

//         $sql = "SELECT * FROM users WHERE email = :email";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute(['email' => $email]);
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($user && password_verify($password, $user['password_hash'])) {
//             return $user;
//         }
//         return null;
//     }
// }
// $login = new AuthController();

// $user = $login->login('amina@gmail.com','amina1234');
// var_dump($user);
// // var_dump($user);
// // if($user){
// //     echo 'Correct';

// // }
// // else{
// //     echo 'not correct';
// // }

use App\config\Database;

class AuthController
{
    public function login()
    {
        echo "Login Page";
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql= 'SELECT * FROM users where email = :email';
        $pdo = Database::connect();
        $stmt= $pdo->prepare($sql);
        $stmt->execute([]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user ==null){
            
        }
    }

    public function register()
    {
        echo "Register Page";
    }
}
