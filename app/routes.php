<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';

Flight::route('GET /', ['AuthController', 'showLogin']);
Flight::route('GET /login', ['AuthController', 'showLogin']);
Flight::route('POST /login', ['AuthController', 'postLogin']);
Flight::route('GET /accueil', ['AuthController', 'showAccueil']);
Flight::route('GET /attribution', ['AuthController', 'showAttribution']);
Flight::route('GET /attribForm', ['AuthController', 'showAttributionForm']);
