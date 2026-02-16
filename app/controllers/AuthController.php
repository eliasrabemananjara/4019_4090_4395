<?php
class AuthController
{

  public static function showLogin()
  {
    Flight::render('auth/login', [
      'values' => ['email' => ''],
      'errors' => ['email' => ''],
      'success' => false
    ]);
  }

  public static function postLogin()
  {
    session_start();

    $pdo  = Flight::db();
    $repo = new UserRepository($pdo);
    $svc  = new UserService($repo);

    $req = Flight::request();

    $input = [
      'email' => $req->data->email ?? '',
    ];

    $res = Validator::validateEmail($input);

    if ($res['ok']) {
      try {
        // Trouver ou créer l'utilisateur
        $user = $svc->findOrCreateUser($res['values']['email']);

        // Stocker les informations en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        // Rediriger vers la page d'accueil
        Flight::redirect('/accueil');
        return;
      } catch (Exception $e) {
        $res['errors']['email'] = "Une erreur est survenue lors de la connexion.";
      }
    }

    Flight::render('auth/login', [
      'values' => $res['values'],
      'errors' => $res['errors'],
      'success' => false
    ]);
  }

  public static function showAccueil()
  {
    Flight::render('auth/accueil');
  }
}
