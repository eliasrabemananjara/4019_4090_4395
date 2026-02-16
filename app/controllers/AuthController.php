<?php

require_once __DIR__ . '/../repositories/StockRepository.php';
require_once __DIR__ . '/../repositories/VilleRepository.php';
require_once __DIR__ . '/../repositories/AttributionRepository.php';

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
    if (isset($_GET['quantite']) && isset($_GET['idproduit']) && isset($_GET['idville']) && isset($_GET['idstock'])) {
      $pdo  = Flight::db();
      $repo = new AttributionRepository($pdo);
      $repo->create($_GET['quantite'], $_GET['idproduit'], $_GET['idville']); 
      $repo2 = new StockRepository($pdo);
      $repo2->decreaseQuantite($_GET['quantite'], $_GET['idproduit'], $_GET['idstock']);
      Flight::render('auth/accueil');
    }
    else {
      Flight::render('auth/accueil');
    }
  }

    public static function showAttribution()
    {
    $pdo  = Flight::db();
    $repo = new StockRepository($pdo);
    $stocks = $repo->findAll();
    Flight::render('auth/attribution', [
      'stocks' => $stocks
    ]);
  }

  public static function showAttributionForm()
  {
    $pdo  = Flight::db();
    $repo = new VilleRepository($pdo);
    $idproduit = $_GET['idproduit'] ?? null;
    $villes = $repo->findByProduit($idproduit);
    Flight::render('auth/attribFrom', [
      'villes' => $villes,
      'idproduit' => $idproduit,
      'idstock' => $_GET['idstock'] ?? null
    ]);
  }
}
