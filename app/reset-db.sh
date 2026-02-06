#!/bin/bash
echo "🗑️  Suppression de la BDD..."
php bin/console doctrine:schema:drop --force --full-database

echo "🏗️  Création de la BDD..."
php bin/console doctrine:schema:create

echo "📦 Chargement des fixtures..."
php bin/console doctrine:fixtures:load --no-interaction

echo "✅ BDD réinitialisée avec succès !"

