<?php
// Function to determine active link
function is_active($path)
{
    $current = $_SERVER['REQUEST_URI'];
    return (strpos($current, $path) !== false) ? 'active' : '';
}
?>

<!-- Sidebar Toggle Button -->

<!-- Vertical Sidebar Menu -->
<aside class="sidebar-menu" id="sidebarMenu">
    <div class="sidebar-header">
        <span class="sidebar-brand">
            <i class="bi bi-heart-pulse-fill text-accent"></i> SOS Cyclone
        </span>
        <button class="btn-close-sidebar" id="sidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <a href="/accueil" class="sidebar-link <?= is_active('/accueil') ?>">
            <i class="bi bi-house-door"></i> Accueil
        </a>
        <a href="/insertBesoins" class="sidebar-link <?= is_active('/insertBesoins') ?>">
            <i class="bi bi-clipboard-plus"></i> Saisir Besoins
        </a>
        <a href="/insertDons" class="sidebar-link <?= is_active('/insertDons') ?>">
            <i class="bi bi-gift"></i> Saisir Dons
        </a>
        <a href="/listesbesoins" class="sidebar-link <?= is_active('/listesbesoins') ?>">
            <i class="bi bi-list-check"></i> Liste & Attribution
        </a>
        <a href="/vente" class="sidebar-link <?= is_active('/vente') ?>">
            <i class="bi bi-cart4"></i> Vente de Stock
        </a>
        <a href="/historiqueAchat" class="sidebar-link <?= is_active('/historiqueAchat') ?>">
            <i class="bi bi-cart-check"></i> Historique Achats
        </a>
        <a href="/recapitulatif" class="sidebar-link <?= is_active('/recapitulatif') ?>">
            <i class="bi bi-bar-chart-fill"></i> Récapitulatif
        </a>
        <a href="/reinitialiser" class="sidebar-link <?= is_active('/reinitialiser') ?>">
            <i class="bi bi-arrow-repeat"></i> Réinitialiser Données
        </a>

        <div class="sidebar-divider"></div>

        <a href="/logout" class="sidebar-link text-danger">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </nav>
</aside>

<!-- Overlay for mobile/when open -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');
        const sidebar = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    });
</script>