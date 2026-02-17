<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/BesoinController.php';
require_once __DIR__ . '/controllers/DonsController.php';
require_once __DIR__ . '/controllers/ListeBesoinController.php';

require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';

require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/repositories/BesoinRepository.php';
require_once __DIR__ . '/repositories/DonsRepository.php';
require_once __DIR__ . '/repositories/ProduitRepository.php';
require_once __DIR__ . '/repositories/VilleRepository.php';
require_once __DIR__ . '/repositories/StockRepository.php';
require_once __DIR__ . '/repositories/AttributionRepository.php';
require_once __DIR__ . '/repositories/PrixUnitaireRepository.php';
require_once __DIR__ . '/controllers/recapitControleur.php';
require_once __DIR__ . '/controllers/HistoriqueAchatController.php';

Flight::route('GET /', ['AuthController', 'showLogin']);
Flight::route('GET /login', ['AuthController', 'showLogin']);
Flight::route('POST /login', ['AuthController', 'postLogin']);
Flight::route('GET /logout', ['AuthController', 'logout']);
Flight::route('GET /accueil', ['AuthController', 'showAccueil']);

Flight::route('GET /insertBesoins', ['BesoinController', 'showInsert']);
Flight::route('POST /insertBesoins', ['BesoinController', 'postInsert']);

Flight::route('GET /insertDons', ['DonsController', 'showInsert']);
Flight::route('POST /insertDons', ['DonsController', 'postInsert']);
Flight::route('GET /listesbesoins', ['ListeBesoinController', 'listeBesoin']);
Flight::route('POST /attribuer', ['ListeBesoinController', 'attribuer']);
Flight::route('GET /recapitulatif', ['RecapitControleur', 'showRecap']);
Flight::route('POST /acheter', ['ListeBesoinController', 'acheter']);
Flight::route('GET /historiqueAchat', ['HistoriqueAchatController', 'index']);
Flight::route('GET /api/recap', ['RecapitControleur', 'getGlobalStats']);
