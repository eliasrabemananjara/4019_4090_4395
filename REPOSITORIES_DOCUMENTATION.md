# Repository Models Documentation

## Overview
This document provides information about the repository classes created for the BNGRC database tables.

## Created Repositories

### 1. RegionRepository
**File:** `app/repositories/RegionRepository.php`
**Table:** `region`

**Methods:**
- `findById($id)` - Find a region by ID
- `findAll()` - Get all regions ordered by name
- `create($nom_region)` - Create a new region
- `update($id, $nom_region)` - Update a region
- `delete($id)` - Delete a region

---

### 2. VilleRepository
**File:** `app/repositories/VilleRepository.php`
**Table:** `ville`

**Methods:**
- `findById($id)` - Find a ville by ID
- `findAll()` - Get all villes with region information
- `findByRegion($idregion)` - Get all villes in a specific region
- `create($nom_ville, $idregion)` - Create a new ville
- `update($id, $nom_ville, $idregion)` - Update a ville
- `delete($id)` - Delete a ville

---

### 3. TypeProduitRepository
**File:** `app/repositories/TypeProduitRepository.php`
**Table:** `type_produit`

**Methods:**
- `findById($id)` - Find a product type by ID
- `findAll()` - Get all product types ordered by name
- `create($nom_type_produit)` - Create a new product type
- `update($id, $nom_type_produit)` - Update a product type
- `delete($id)` - Delete a product type

---

### 4. ProduitRepository
**File:** `app/repositories/ProduitRepository.php`
**Table:** `produit`

**Methods:**
- `findById($id)` - Find a product by ID
- `findAll()` - Get all products with type information
- `findByType($idtype_produit)` - Get all products of a specific type
- `create($nom_produit, $idtype_produit)` - Create a new product
- `update($id, $nom_produit, $idtype_produit)` - Update a product
- `delete($id)` - Delete a product

---

### 5. BesoinRepository
**File:** `app/repositories/BesoinRepository.php`
**Table:** `besoin`

**Methods:**
- `findById($id)` - Find a need by ID
- `findAll()` - Get all needs with product and ville information
- `findByVille($id_ville)` - Get all needs for a specific ville
- `findByProduit($idproduit)` - Get all needs for a specific product
- `create($quantite, $idproduit, $id_ville)` - Create a new need
- `update($id, $quantite, $idproduit, $id_ville)` - Update a need
- `delete($id)` - Delete a need
- `getTotalByProduit($idproduit)` - Get total quantity needed for a product

---

### 6. DonsRepository
**File:** `app/repositories/DonsRepository.php`
**Table:** `dons`

**Methods:**
- `findById($id)` - Find a donation by ID
- `findAll()` - Get all donations with product and user information
- `findByUser($iduser)` - Get all donations by a specific user
- `findByProduit($idproduit)` - Get all donations for a specific product
- `create($iduser, $quantite, $idproduit)` - Create a new donation
- `update($id, $iduser, $quantite, $idproduit)` - Update a donation
- `delete($id)` - Delete a donation
- `getTotalByProduit($idproduit)` - Get total donations for a product
- `getTotalByUser($iduser)` - Get total donations by a user

---

### 7. StockRepository
**File:** `app/repositories/StockRepository.php`
**Table:** `stock`

**Methods:**
- `findById($id)` - Find a stock entry by ID
- `findAll()` - Get all stock entries with product information
- `findByProduit($idproduit)` - Get all stock entries for a specific product
- `getCurrentStock($idproduit)` - Get current stock quantity for a product
- `create($idproduit, $quantite)` - Create a new stock entry
- `update($id, $idproduit, $quantite)` - Update a stock entry
- `delete($id)` - Delete a stock entry
- `addStock($idproduit, $quantite)` - Helper to add stock
- `removeStock($idproduit, $quantite)` - Helper to remove stock
- `getAllCurrentStocks()` - Get current stock levels for all products

---

### 8. AttributionRepository
**File:** `app/repositories/AttributionRepository.php`
**Table:** `attribution`

**Methods:**
- `findById($id)` - Find an attribution by ID
- `findAll()` - Get all attributions with product, ville, and region information
- `findByVille($id_ville)` - Get all attributions for a specific ville
- `findByProduit($idproduit)` - Get all attributions for a specific product
- `create($quantite, $idproduit, $id_ville)` - Create a new attribution
- `update($id, $quantite, $idproduit, $id_ville)` - Update an attribution
- `delete($id)` - Delete an attribution
- `getTotalByProduit($idproduit)` - Get total attributions for a product
- `getTotalByVille($id_ville)` - Get total attributions for a ville
- `getAttributionsByRegion($idregion)` - Get all attributions for a region

---

## Usage Example

```php
<?php
// In your controller or service

// Get PDO connection
require_once __DIR__ . '/../app/bootstrap.php';

// Instantiate repository
$regionRepo = new RegionRepository($pdo);

// Create a new region
$newRegionId = $regionRepo->create('Analamanga');

// Find all regions
$regions = $regionRepo->findAll();

// Find a specific region
$region = $regionRepo->findById($newRegionId);

// Update a region
$regionRepo->update($newRegionId, 'Analamanga Updated');

// Delete a region
$regionRepo->delete($newRegionId);
```

## Advanced Usage Examples

### Working with Stock Management
```php
$stockRepo = new StockRepository($pdo);
$produitRepo = new ProduitRepository($pdo);

// Get current stock for a product
$currentStock = $stockRepo->getCurrentStock(1);

// Add stock
$stockRepo->addStock(1, 100); // Add 100 units

// Remove stock
$stockRepo->removeStock(1, 50); // Remove 50 units

// Get all current stocks
$allStocks = $stockRepo->getAllCurrentStocks();
```

### Tracking Donations and Needs
```php
$donsRepo = new DonsRepository($pdo);
$besoinRepo = new BesoinRepository($pdo);

// Get total donations for a product
$totalDons = $donsRepo->getTotalByProduit(1);

// Get total needs for a product
$totalBesoins = $besoinRepo->getTotalByProduit(1);

// Calculate deficit/surplus
$balance = $totalDons - $totalBesoins;
```

### Managing Attributions by Region
```php
$attributionRepo = new AttributionRepository($pdo);
$regionRepo = new RegionRepository($pdo);

// Get all attributions for a specific region
$attributions = $attributionRepo->getAttributionsByRegion(1);

// Get total attributions for a ville
$totalForVille = $attributionRepo->getTotalByVille(1);
```

## Notes

1. All repositories follow the same pattern for consistency
2. Methods return associative arrays (PDO::FETCH_ASSOC)
3. JOIN queries are used to include related data
4. Aggregate functions (SUM) are provided for reporting
5. All parameters are properly type-cast for security
6. Prepared statements are used to prevent SQL injection

## Database Connection

The repositories use PDO connection defined in `app/config.php`:
- Host: 127.0.0.1
- Database: 4019_4090_4395
- User: root
- Password: (empty)
- Charset: utf8mb4
