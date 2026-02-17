<?php
require_once __DIR__ . '/../repositories/AchatRepository.php';

class HistoriqueAchatController
{
    public static function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $pdo = Flight::db();
        $achatRepo = new AchatRepository($pdo);

        // Get all purchases
        $achats = $achatRepo->findAll();

        Flight::render('auth/historiqueAchat', [
            'achats' => $achats
        ]);
    }
}
