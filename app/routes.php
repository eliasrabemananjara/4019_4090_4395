<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ConversationController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/ConversationService.php';
require_once __DIR__ . '/services/MessageService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/repositories/ConversationRepository.php';
require_once __DIR__ . '/repositories/MessageRepository.php';

Flight::route('GET /', ['AuthController', 'showLogin']);
Flight::route('GET /login', ['AuthController', 'showLogin']);
Flight::route('POST /login', ['AuthController', 'postLogin']);
