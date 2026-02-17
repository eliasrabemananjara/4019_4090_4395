<?php

require_once __DIR__ . '/../repositories/ReinitialiserRepository.php';

class ReinitialiserController
{
  public static function reinitialiser()
  {
    $pdo = Flight::db();
    $repo = new ReinitialiserRepository($pdo);
    $repo->reinitialiserDonnees();
    Flight::redirect('/accueil');
  }
}
